---
name: JS code organization
description: User prefers modular JS files instead of everything in main.js
type: feedback
---

Keep JS organized in separate module files under `src/js/modules/`. The `main.js` should only contain imports — no inline logic.

**Why:** User explicitly asked for better organization when main.js was getting cluttered with mixed concerns (sliders, dark mode, smooth scroll all in one file).

**How to apply:** When adding new JS functionality, always create a new module file in `src/js/modules/` and import it from `main.js`.
