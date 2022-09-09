# Changelog

All notable changes to `tall-interactive` will be documented in this file.

## 0.8.10 - 2022-08-19

– Fix type-error bug after Filament refactored internal implementation.

## 0.8.9 - 2022-08-15

– Add ButtonAction color support.
– Add CSS button classes.

## 0.8.8 - 2022-06-24

– Add support for hiding ButtonActions.

## 0.8.7 - 2022-06-03

– Fix: trying to close Inline Form on submit.

## 0.8.6 - 2022-03-17

- Fix submitting slots with Livewire component.

## 0.8.5 - 2022-03-17

- Feature: Add $params to included Livewire components

## 0.8.4 - 2022-03-17

- Fix: receive Livewire parameter in components.

## 0.8.3 - 2022-03-10

- Update modal fix on mobile

## 0.8.2 - 2022-03-03

- Remove unused files

## 0.8.1 - 2022-02-25

- Fixes for mobile design with multiple / longer buttons in the modal and slideover

## 0.8.0 - 2022-02-24

- Add support for adding a `fill()` method on the form class, which will be passed to `$this->form->fill()`
- Rename parameter `$formData` to `$state`
- Rename method `submitForm()` to `submit()`

## 0.7.0 - 2022-02-24

- Add dark mode support to the modal component

## 0.6.3 - 2022-02-23

- DOM diffing issues

## 0.6.2 - 2022-02-23

- Update wire:key implementation

## 0.6.1 - 2022-02-23

- Fixes

## 0.6.0 - 2022-02-23

- Refactoring, move everything to `$data` property

## 0.5.0 - 2022-02-22

- Add support for additional button actions

## 0.4.3 - 2022-02-21

- Fix overflow/border-radius on small modals

## 0.4.2 - 2022-02-16

- Add `key()` directives to modal/slide-over to fix DOM diffing issues

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
