# Release notes for Craft Video Parser

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 5.0.0 - 2024-03-26
### Added
- Craft 5 support 🚀

## 2.2.0 - 2024-03-01
### Added
- Added support for Youtube url parameters ([#1](https://github.com/statikbe/craft-video-parser/issues/1))


## 2.1.3 - 2023-12-8
### Fixed
- Fixed an issue where inputting an unparseable url would throw an error instead of returning null

## 2.1.2 - 2023-10-02
### Fixed
- Fixed regression in vimeo link because i forgot to put an optional signifier in the regex

## 2.1.1 - 2023-09-15
### Fixed
- Fixed an issue where Video could not properly parse Vimeo url formatted like 'https://vimeo.com/123456789/123456789'

## 2.1.0 - 2022-07-27
### Added
- Added support for embeding Youtube Playlists ([#2](https://github.com/statikbe/craft-video-parser/issues/2))


## 2.0.1 - 2022-07-15
### Fixed
- Fixed required Craft version

## 2.0.0 - 2022-07-15
### Added
- Craft 4 compatibility
- Support for YouTube Shorts videos


## 2.0.0-beta.1 - 2022-03-15
### Added
- Craft 4 compatibility

## 1.2.2 - 2022-02-28
### Fixed
- Made compatible with PHP 7

## 1.1.0 - 2021-09-16
### Added
- Added support for youtube-nocookie.com urls

## 1.0.0 - 2021-04-11
### Added
- Initial release 🎉
