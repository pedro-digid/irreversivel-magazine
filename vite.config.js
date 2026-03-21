import { defineConfig } from 'vite';
import { resolve } from 'path';
import fs from 'fs';

const DEV_PORT = 5173;
const DEV_URL  = `http://localhost:${DEV_PORT}`;

/**
 * Plugin that triggers a full page reload when PHP files change.
 */
function wordpressPhpReload() {
  return {
    name: 'wordpress-php-reload',

    configureServer(server) {
      server.watcher.add(resolve(__dirname, '**/*.php'));

      server.watcher.on('change', (path) => {
        if (path.endsWith('.php')) {
          server.ws.send({ type: 'full-reload' });
        }
      });
    },
  };
}

/**
 * Plugin that creates a `dist/hot` file while the dev server runs.
 * The PHP helper reads this file to know whether to load from dev server or manifest.
 */
function wordpressHotFile() {
  const hotFilePath = resolve(__dirname, 'dist/hot');

  return {
    name: 'wordpress-hot-file',

    configureServer(server) {
      server.httpServer?.once('listening', () => {
        fs.mkdirSync(resolve(__dirname, 'dist'), { recursive: true });
        fs.writeFileSync(hotFilePath, DEV_URL);
      });

      const cleanup = () => {
        if (fs.existsSync(hotFilePath)) {
          fs.unlinkSync(hotFilePath);
        }
      };

      process.on('exit', cleanup);
      process.on('SIGINT', () => { cleanup(); process.exit(); });
      process.on('SIGTERM', () => { cleanup(); process.exit(); });
    },
  };
}

export default defineConfig({
  plugins: [
    wordpressPhpReload(),
    wordpressHotFile(),
  ],

  build: {
    outDir: resolve(__dirname, 'dist'),
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/js/main.js'),
      },
    },
  },

  css: {
    preprocessorOptions: {
      sass: {
        silenceDeprecations: ['import'],
      },
    },
  },

  server: {
    origin: DEV_URL,
    port: DEV_PORT,
    strictPort: true,
    cors: true,
  },
});
