/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  config.language = "en"; // ngon ngu
  config.skin = 'office2013';
  
  config.toolbar_Admin = [
    { name: "document", items: ["Preview"] },
    { name: "basicstyles", items: ["Bold", "Italic","Underline","Strike","-","RemoveFormat"] },
    { name: "styles", items: ["FontSize", "Font"] },//"Styles","Font","Format",
    { name: "color", items: ["TextColor","BGColor"] },
    { name: "tools", items: ["Maximize","About"] },//"ShowBlocks","-",  

  ];
  config.removePlugins = 'iframe';
  config.extraPlugins = 'youtube';
  //config.toolbar = 'Admin';
  config.removePlugins = 'about,forms';//xoa cac plugins( xem ten plugin trong thu muc plugins)
  

  
};
