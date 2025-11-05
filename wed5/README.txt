wed4 – MVC project (fixed)
- MVC folders: controllers/, models/, views/
- Dark/Light theme cookie with toggle. No language feature.
- Remember-me cookie (DB-backed). No storing password in session.
- Views do not embed PHP inside returned HTML strings; UI toggles are echoed in the controller after rendering.
Setup:
1) Put entire wed4 folder under your MAMP htdocs.
2) Visit /wed4/index.php; DB tables (including remember_tokens) are created by database.php.
3) Use the bottom-right theme toggle, or add ?theme=dark to the URL.