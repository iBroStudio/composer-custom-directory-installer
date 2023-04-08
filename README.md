# Composer Custom Directory Installer

This package is project based on [Laravel Module Installer](https://github.com/joshbrw/laravel-module-installer) extended to work with different types of packages.
It allows installation of standalone packages into a custom directory instead of `vendor/`.

## Installation
In your **main project**, run
```bash
composer require ibrostudio/composer-custom-directory-installer
```

At the end of the composer installation, you will be asked to add the package in the "allow-plugins" section of your composer.json. **Confirmation is mandatory**

## Configuration
In the **composer.json of your package**, set these keys :
```bash
"type": "custom-library",
"extra": {
    "custom-directory-installer": {
      "directory": "DESTINATION_FOLDER"
    }
}
```
Replace *DESTINATION_FOLDER* with the name of the directory, relative to the root of your main project where you want to install the package.

**Example:**

```bash
"type": "custom-library",
"extra": {
    "custom-directory-installer": {
      "directory": "themes"
    }
}
```

## Usage
Simply require your composer package as usual:
```bash
composer require vendor_name/package_name
```
Your package will be installed in a subfolder called package_name in the directory defined in the extra section.

## Options
Your package name can have sometimes a prefix or a suffix, like:
- vendor_name/theme-package_name
- vendor_name/package_name-theme
- vendor_name/platform-package_name-theme

For convenience and lisibility, you can specify the prefix and/or suffix in the extra configuration to exclude them from the folder name:

**prefix**
```bash
"name": "vendor_name/theme-my_project",
"extra": {
    "custom-directory-installer": {
      "directory": "themes",
      "name": {
        "prefix": "theme-"
      }
    }
}
```

**suffix**
```bash
"name": "vendor_name/my_project-theme",
"extra": {
    "custom-directory-installer": {
      "directory": "themes",
      "name": {
        "suffix": "-theme"
      }
    }
}
```
**both**
```bash
"name": "vendor_name/platform-my_project-theme",
"extra": {
    "custom-directory-installer": {
      "directory": "themes",
      "name": {
        "prefix": "platform-",
        "suffix": "-theme"
      }
    }
}
```
In these 3 examples, the package will be installed in /themes/my_project