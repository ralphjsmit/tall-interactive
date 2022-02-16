# Changelog

All notable changes to `tall-interactive` will be documented in this file.

## 0.4.1 - 2022-02-16

- Update the order of the `mount()` call

## 0.4.0 - 2022-02-16

- All methods on the form class are not static anymore.
- Allow storing data on the form class.
- Add new parameters to dependency injection functionality.
- Update readme with better examples.
- Add support for `mount()` method on the form class, which is only called once.
- Method `initialize()` dropped in favour of `mount()`.
- Method `onOpen()` added to receive event parameters.

## 0.3.0 - 2022-02-10

- Fix: let `:close` event also open the last actionable again
- Feat: increased return type support
- Feat: allow child modals to force close all the other modals

## 0.2.2 - 2022-01-28

- Fix: allow receiving the `$formVersion` parameter

## 0.2.1 - 2022-01-27

- Fix z-index overlay problems

## 0.2.0 - 2022-01-27

- The `$formData` parameter in the `submitForm()` method is now a `Illuminate\Support\Collection`

## 0.1.0 - 2022-01-26

- Pre-release
