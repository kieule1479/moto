/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  config.language = "vi"; // ngon ngu
  config.uiColor = "#18a2b8"; // mau sac
  config.height = 100;

  config.toolbar_Admin = [
    { name: "document", items: ["Preview"] },
    { name: "basicstyles", items: ["Bold", "Italic","Underline","Strike","-","RemoveFormat"] },
    { name: "styles", items: ["FontSize", "Font"] },//"Styles","Font","Format",
    { name: "color", items: ["TextColor","BGColor"] },
    { name: "tools", items: ["Maximize","About"] },//"ShowBlocks","-",  

  ];
  // config.toolbar_Full = [
  //   { name: "document", items: ["Source","Preview"] },
  //   { name: "clipboard", items: ["Cut", "Copy","Paste","-","Undo","Redo"] },
  //   { name: "editing", items: ["Find", "Replace","-","SelectAll"] },
  //   { name: "basicstyles", items: ["Bold", "Italic","Underline","Strike","-","RemoveFormat"] },
  //   { name: "paragraph", items: ["NumberedList", "BulletedList","-","JustifyLeft","JustifyCenter","JustifyRight"] },
  //   { name: "links", items: ["Link","Unlink"] },
  //   { name: "insert", items: ["Image","Flash", "Table"] },
  //   { name: "styles", items: ["Styles","Font","Format","FontSize"] },
  //   { name: "color", items: ["TextColor","BGColor"] },
  //   { name: "tools", items: ["Maximize","ShowBlocks","-","About"] },

  // ];
  config.toolbar = 'Admin';
  config.removePlugins = 'about,forms';//xoa cac plugins( xem ten plugin trong thu muc plugins)

  
};
