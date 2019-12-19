# Frontity WP Plugins

## How to collaborate

#### 1. Fork this repo to your GitHub account.

#### 2. Clone the fork in your computer.

#### 3. Add the plugins to your WordPress installation.

You can add them using symlinks:

```bash
npm run sync ../../path/to/your/wordpress
```

If you work with [Local by Flywheel](https://localbyflywheel.com/) you have to use their addon [ Volumes ](https://localbyflywheel.com/add-ons/volumes) to add the plugins to the WordPress.

#### 4. Make the modifications to the code.

#### 5. Submit a Pull Request.

## WordPress Code Standards and Unit Tests

### Installation in macOS

#### 1. Install PHP.

Our recommendation is to use Homebrew:

```bash
brew install php
```

#### 2. Install Composer.

Our recommendation is to use Hombrew:

```bash
brew install composer
```

Then, install the dependencies:

```bash
composer install
```

#### 3. Install MySQL (for unit tests only)

Our recommendation is to use [DBngin](https://dbngin.com/).

Once you've installed DBngin, create a new MySQL database (v5.7) and click on "Start".

Then, click on the terminal icon and add the line it shows
to your `.bash_profile` or `.zshrc` file:

```bash
# DBngin exports
export PATH=/Users/Shared/DBngin/mysql/5.7.23/bin:$PATH
```

Change `5.7.23` for your MySQL version.

#### 4. Install Xdebug (for debugging of unit tests)

Our recommendation is to use `pecl`:

```bash
pecl install xdebug
```

After the installation, add an extension with the Xdebug configuration at `/usr/local/etc/php/7.X/conf.d/ext-xdebug.ini`:

```
[xdebug]
zend_extension=/usr/local/Cellar/php/7.X/pecl/YYYYYYYY/xdebug.so
xdebug.remote_enable=1
xdebug.remote_port=9000
```

Change `7.X` for your PHP version and YYYYYY for the folder where pecl installed Xdebug.

You may need to clean your previous PHP installation first, then install it again with brew. [This post](https://medium.com/@romaninsh/install-php-7-2-xdebug-on-macos-high-sierra-with-homebrew-july-2018-d7968fe7e8b8) explains the process. You can skip the Nginx section.

You may need to remove the first line that the pecl installation added to your `php.ini` file at `/usr/local/etc/php/7.X/php.ini`.

### Run the code standards and beautifier

You can use these two commands to check that your code meets the WordPress standards:

```bash
npm run phpcs
npm run phpcbf
```

### Run the unit tests

The first time, you need to install the database and download WordPress

```bash
npm run install-wp-tests
```

This will run `bin/install-wp-tests.sh` with the following parameters:

- DB_NAME=frontity-tests
- DB_USER=root
- DB_PASS='' (blank)
- DB_HOST=localhost
- WP_VERSION=latest
- SKIP_DB_CREATE=false

You can also run it manually if you prefer.

Then, use `npm run phpunit` to run the tests.
