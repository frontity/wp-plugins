# frontity-headtags

## 1.1.3

### Patch Changes

- [`a46927b`](https://github.com/frontity/wp-plugins/commit/a46927bbde468157e85fe247b72ad44895ccf50d) [#29](https://github.com/frontity/wp-plugins/pull/29) - Fix redirects to images when making calls to the REST API in a site with Yoast installed. Also, refactor the code to prevent other redirections in the future.

## 1.1.2

### Patch Changes

- [`8159151`](https://github.com/frontity/wp-plugins/commit/81591510a74fc053999e78ea9fd690d50f760bde) [#23](https://github.com/frontity/wp-plugins/pull/23) - Fix the performance of the clear cache functionality.

* [`f15f02a`](https://github.com/frontity/wp-plugins/commit/f15f02a2f0163547ab120b918455df1ff73eb2d7) [#22](https://github.com/frontity/wp-plugins/pull/22) - Fix the way admin hooks and rest api hooks are being registered.

  - `admin_init` is used for `register_admin_hooks`
  - `rest_api_init` is used for `register_rest_hooks`

## 1.1.1

### Patch Changes

- [`fab8711`](https://github.com/frontity/wp-plugins/commit/fab87113b088c8d37426bce58ad997a135a33c56) [#21](https://github.com/frontity/wp-plugins/pull/21) - Fix redirects when making calls to the REST API

## 1.1.0

### Minor Changes

- [`12638a8`](https://github.com/frontity/wp-plugins/commit/12638a86dab060a3ec5a948b83dd5ea912ae413f) [#17](https://github.com/frontity/wp-plugins/pull/17) - Added integration with All In One SEO Pack.

## 1.0.1

### Patch Changes

- [`0200a05`](https://github.com/frontity/wp-plugins/commit/0200a05ddb59d577d69eef54e7632e38a91b2eba) [#16](https://github.com/frontity/wp-plugins/pull/16) - Fix the registering of activation / deactivation hooks.

## 1.0.0

### Major Changes

- Release the first version of REST API - Head Tags
