/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  config.toolbar_Admin = [{ name: "document", items: ["Preview"] }];
  config.extraPlugins = "youtube";
  config.removePlugins = "about,forms,clipboard, flash";
  // config.toolbar = "Admin";
};
