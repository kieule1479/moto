/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
		config.language = 'vi';// ngon ngu
		config.uiColor = '#AADC6E';// mau sac
		// config.with = 1000; // chieu rong
		// config.height = 1000; // chieu cao
		// config.resize_dir= 'horizontal';// thay doi chieu rong
		// config.resize_dir= 'vertical';// thay doi chieu cao
		config.resize_enabled = false;
		// config.resize_dir= 'both';// thay doi ca 2

		config.enterMode = CKEDITOR.ENTER_BR;// xuong dong  = br
	
};
