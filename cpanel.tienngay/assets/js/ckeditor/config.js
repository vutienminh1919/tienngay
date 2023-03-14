/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'vi';
	var base_url=window.location.origin+"/assets/js/";
config.filebrowserBrowseUrl = base_url+"ckfinder/ckfinder.html"; 
config.filebrowserImageBrowseUrl =  base_url+"ckfinder/ckfinder.html?type=Images";
config.filebrowserFlashBrowseUrl = base_url+"ckfinder/ckfinder.html?type=Flash"; 
config.filebrowserUploadUrl =  base_url+"ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
config.filebrowserImageUploadUrl = base_url+"ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
config.filebrowserFlashUploadUrl = base_url+"ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";


};
