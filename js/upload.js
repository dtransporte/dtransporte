(function($){
	'use strict';
	$.fn.Upload = function(options, method){
		var defaults = {
			runtimes : 'html5,html4',//,flash,silverlight
			url: BaseUrl+'index.php/upload',
			rename : false,
			dragdrop: true,
			filters : {
				// Maximum file size
				max_file_size : '300kb',
				// Specify what files to browse for
				mime_types: [
					{title : "Image files", extensions : "jpg,gif,png"},
				]
			},
			// Resize images on clientside if we can
			resize: {
				width : 200,
				height : 200,
				quality : 90,
				crop: true // crop to exact dimensions
			},
			multipart_params: {}, // Parametros adicionlaes a ser enviados
			multi_selection: false,
			isUserImage: 0,
			
			//flash_swf_url: BaseUrl+'application/vendor/moxiecode/plupload/js/Moxie.swf',
			//silverlight_xap_url: BaseUrl+'application/vendor/moxiecode/plupload/js/Moxie.xap',
		},
		settings = $.extend(true, defaults, options),
		that = this,

		methods = {
			construct: function(){
				settings.url = BaseUrl+settings.url;
				settings.preinit = {
					Init: function(up, info){
						window.alert = function(){};
					}
				};
				settings.init = {
					Error: function(up, error){
						DomRootEl.Message({cls: 'danger', message: error.message}, 'set')
					},
					FilesAdded: function(up, files){
						var list = that.find('ul.plupload_filelist li');
						list.each(function(){
							var self = $(this);
							self
							.append('<a href="#"></a>')
							.addClass('plupload_delete')
							.on('click', function(e){
								e.stopPropagation();
								up.removeFile(files[self.index()]);
								self.remove()
							})
						})
					},
					FileUploaded: function(up, file, result){
						var r = $.parseJSON(result.response);

						up.settings = r.data;
						up.settings.isUserImage = r.data.multipart_params.isUserImage;
						DomRootEl.Message(r.message, 'set');
						if(up.settings.isUserImage == 1){
							_setUserImage(file.name)
						}
						if(up.settings.multipart_params.previewContainer != null){
							_showRequirementPreview(file, up.settings)
						}
					},
					UploadComplete: function(up, files){
						that.Upload(up.settings, 'start');
					}
				}
			},
			start: function(){
				that.pluploadQueue(settings);
			}
		}
		
		methods.construct();
		if(method != undefined){
			methods[method].apply(this);
		}
		return this;

		function _setUserImage(file){
			var img = DomRootEl.find('#nav-user-image');
			img.attr('src', BaseUrl+'dtr-users/'+Uid+'/me/'+file)
		}

		function _showRequirementPreview(file, sets){
			var img = BaseUrl+'dtr-users/'+Uid+'/temp/'+file.name,
				html = _setHtml(file),
				container = DomRootEl.find('#'+sets.multipart_params.previewContainer),
				len = container.find('div.image-uploaded').length;

			if(len >= sets.multipart_params.maxFilesUpload){
				return;
			}
			else{
				container
					.append(html)
					.find('a.btn-delete-image')
					.on('click', function(){
						_removeFile($(this), file)
					})
			}
		}

		function _setHtml(file){
			var img = BaseUrl+'dtr-users/'+Uid+'/temp/'+file.name,
				html = '';
			html += '<div class="text-center image-uploaded">';
				html += '<img src="'+img+'" class="rounded" style="width: 100px; height: 100px">';
				html += '<p class="text-dark"><span class="file-name">'+file.name+'</span><a role="button" class="btn btn-sm btn-danger btn-delete-image"><i class="fas fa-trash-alt"></i></a></p>';
			html += '</div>';
			return html;
		}

		function _removeFile(el, file){
			var f = file == undefined ? el.closest('div').find('span.file-name').text() : file.name;
			$.fn.request({
				url: BaseUrl+'index.php/Requirements/Images/delete',
				type: 'GET',
				data: {file_name: f},
				showLoadingBar: true
			}).then(
				function(response){
					if(response === 'ok'){
						el.closest('div.image-uploaded').remove();
					}
				}
			)
		}
	}
})(jQuery);