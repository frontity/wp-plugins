---
"frontity-headtags": patch
---

Fix the way admin hooks and rest api hooks are being registered.

- `admin_init` is used for `register_admin_hooks`
- `rest_api_init` is used for `register_rest_hooks`
