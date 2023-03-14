$(document).ready(function () {
	$('.show_info_btn_chose').click(function () {
		var id = $(this).attr('data-id')
		var type = $(this).attr('data-type')
		$.ajax({
			url: _url.base_url + 'property/detail_property?id=' + id + '&type=' + type,
			type: "GET",
			dataType: 'json',
			success: function (result) {
				console.log(result.data.dong_xe)
				$('.ten_tai_san').empty('');
				$('.dong_xe').empty('');
				$('.nam_san_xuat').empty('');
				$('.gia_xe').empty('');
				$('.khau_hao_tieu_chuan').empty('');
				$('#depreciations').empty('');
				$("#history_tai_san").empty('');
				$('.id_update').empty('')
				$('.ten_tai_san').text(typeof result.data.str_name === undefined ? '' : result.data.str_name);
				$('.dong_xe').text(typeof result.data.dong_xe === undefined ? '' : result.data.dong_xe);
				$('.nam_san_xuat').text(typeof result.data.year_property === undefined ? '' : result.data.year_property);
				$('.khau_hao_tieu_chuan').text(typeof result.data.giam_tru_tieu_chuan === undefined ? '' : result.data.giam_tru_tieu_chuan + '%');
				$('.gia_xe').text(typeof result.data.price === undefined ? 0 : result.data.price);
				$('.id_update').val(id)

				$.each(result.data.history, function (i, j) {
						console.log(result.data.history)
						temp = "<tr><td>" + ++i + "</td><td>" + j.type_history + "</td><td>" + j.price + "</td><td>" + j.created_at + "</td></tr>";
						$("#history_tai_san").append(temp);
				});

				$.each(result.data.depreciations, function (k, v) {
					temp = "<tr><td>" + ++k + "</td><td>" + v.name + "</td><td class='text-danger'>" + v.price + "%" + "</td></tr>";
					$("#depreciations").append(temp);
				})
			},
			error: function () {
				alert('error')
			}
		})
	})
	$('.show_info_btn_chose_phe_duyet').click(function () {
		var id = $(this).attr('data-id')
		var type = $(this).attr('data-type')
		$.ajax({
			url: _url.base_url + 'property/detail_property_approve?id=' + id + '&type=' + type,
			type: "GET",
			dataType: 'json',
			success: function (result) {
				console.log(result.data)
				$('.ten_tai_san_phe_duyet').empty('');
				$('.dong_xe_phe_duyet').empty('');
				$('.nam_san_xuat_phe_duyet').empty('');
				$('.gia_xe_phe_duyet').empty('');
				$('.khau_hao_tieu_chuan_phe_duyet').empty('');
				$('#depreciations_phe_duyet').empty('');
				$('.ten_tai_san_phe_duyet').text(typeof result.data.str_name === undefined ? '' : result.data.str_name);
				$('.dong_xe_phe_duyet').text(typeof result.data.dong_xe === undefined ? '' : result.data.dong_xe);
				$('.nam_san_xuat_phe_duyet').text(typeof result.data.year_property === undefined ? '' : result.data.year_property);
				$('.khau_hao_tieu_chuan_phe_duyet').text(typeof result.data.giam_tru_tieu_chuan === undefined ? '' : result.data.giam_tru_tieu_chuan + '%');
				if( result.data.new === undefined){
					$('.gia_xe_phe_duyet').text(result.data.price);
				}else {
					$('.gia_xe_phe_duyet').text(result.data.new_price);
				}
				$.each(result.data.depreciations, function (k, v) {
					temp = "<tr><td>" + ++k + "</td><td>" + v.name + "</td><td class='text-danger'>" + v.price + "%" + "</td></tr>";
					$("#depreciations_phe_duyet").append(temp);
				})
			},
			error: function () {
				alert('error')
			}
		})
	})


	$("#select_asset").change(function () {
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		window.location.href = _url.base_url + "property?property=" + property + '&tab=' + tab;
	})


	$('#search_tab_khau_hao').click(function () {
		let property = $("select[name='property']").val()
		let hang_xe_khau_hao = $("select[name='hang_xe_khau_hao']").val()
		let phan_khuc_khau_hao = $("select[name='phan_khuc_khau_hao']").val()
		let tab = $("input[name='tab']").val()
		window.location.href = _url.base_url + "property?property=" + property + '&tab=' + tab + '&hang_xe_khau_hao=' + hang_xe_khau_hao + '&phan_khuc_khau_hao=' + phan_khuc_khau_hao;
	})

	$('#search_tab_phe_duyet_khau_hao').click(function () {
		let property = $("select[name='property']").val()
		let hang_xe_khau_hao = $("select[name='hang_xe_phe_duyet_khau_hao']").val()
		let phan_khuc_khau_hao = $("select[name='phan_khuc_phe_duyet_khau_hao']").val()
		let tab = $("input[name='tab']").val()
		window.location.href = _url.base_url + "property?property=" + property + '&tab=' + tab + '&hang_xe_khau_hao=' + hang_xe_khau_hao + '&phan_khuc_khau_hao=' + phan_khuc_khau_hao;
	})

	$('.hang_xe_tai_san').change(function () {
		$('.model_tai_san option').remove()
		let id = $("select[name='hang_xe_tai_san']").val()
		console.log(id)
		$.ajax({
			url: _url.base_url + 'property/get_property_by_main?id=' + id,
			type: "GET",
			dataType: 'json',
			success: function (result) {
				if (result.code == 200) {
					$('.model_tai_san').append($('<option>', {value: '', text: 'Chọn model'}));
					$.each(result.data, function (k, v) {
						$('.model_tai_san').append($('<option>', {value: k, text: v}));
					})
				} else {
					$('.model_tai_san').append($('<option>', {value: '', text: 'Chọn model'}));
				}
			},
			error: function () {
				alert('error')
			}
		})
	})


	$('#search_tab_tai_san').click(function () {
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let phan_khuc_tai_san = $("select[name='phan_khuc_tai_san']").val()
		let loai_xe_tai_san = $("select[name='loai_xe_tai_san']").val()
		let nam_san_xuat_tai_san = $("input[name='nam_san_xuat_tai_san']").val()
		let hang_xe_tai_san = $("select[name='hang_xe_tai_san']").val()
		let model_tai_san = $("select[name='model_tai_san']").val()
		console.log(nam_san_xuat_tai_san)
		window.location.href = _url.base_url + "property?property=" + property + '&tab=' + tab + '&phan_khuc_tai_san=' + phan_khuc_tai_san
			+ '&loai_xe_tai_san=' + loai_xe_tai_san + '&nam_san_xuat_tai_san=' + nam_san_xuat_tai_san + '&hang_xe_tai_san=' + hang_xe_tai_san
			+ '&model_tai_san=' + model_tai_san;
	});

	$('#search_tab_lich_su').click(function () {
		let property = $("select[name='property']").val()
		let hang_xe_lich_su = $("input[name='hang_xe_lich_su']").val()
		let phan_khuc_lich_su = $("select[name='phan_khuc_lich_su']").val()
		let nam_lich_su = $("input[name='nam_lich_su']").val()
		let model_lich_su = $("input[name='name_lich_su']").val()
		let loai_xe_lich_su = $("select[name='loai_xe_lich_su']").val()
		let tab = $("input[name='tab']").val()
		window.location.href = _url.base_url + "property?property=" + property + '&tab=' + tab + '&hang_xe_tai_san=' + hang_xe_lich_su + '&phan_khuc_tai_san=' + phan_khuc_lich_su +
		'&nam_san_xuat_tai_san=' + nam_lich_su + '&model_tai_san=' + model_lich_su + '&loai_xe_tai_san=' + loai_xe_lich_su
		;
	});

	$('#search_tab_phe_duyet_tai_san').click(function () {
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let phan_khuc_tai_san = $("select[name='phan_khuc_phe_duyet_tai_san']").val()
		let loai_xe_tai_san = $("select[name='loai_xe_phe_duyet_tai_san']").val()
		let nam_san_xuat_tai_san = $("input[name='nam_san_xuat_phe_duyet_tai_san']").val()
		let hang_xe_tai_san = $("input[name='hang_xe_phe_duyet_tai_san']").val()
		let hang_xe_tai_san_upper = hang_xe_tai_san.charAt(0).toUpperCase() + hang_xe_tai_san.slice(1);

		let model_tai_san = $("input[name='model_phe_duyet_tai_san']").val()
		console.log(nam_san_xuat_tai_san)
		window.location.href = _url.base_url + "property?property=" + property + '&tab=' + tab + '&phan_khuc_tai_san=' + phan_khuc_tai_san
			+ '&loai_xe_tai_san=' + loai_xe_tai_san + '&nam_san_xuat_tai_san=' + nam_san_xuat_tai_san + '&hang_xe_tai_san=' + hang_xe_tai_san_upper
			+ '&model_tai_san=' + model_tai_san;
	})

	$("#import_khau_hao_xm").click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		var inputimg = $('input[name=import_khau_hao]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);
		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'property/import_khau_hao_xm',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$('#add_depreciation').hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.res) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					// }, 2000);
				}

			},
			error: function (data) {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text("error");
				// setTimeout(function () {
				// 	window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
				// }, 2000);
			}
		});
	});


	$("#import_khau_hao_oto").click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		var inputimg = $('input[name=import_khau_hao]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'property/import_khau_hao_oto',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$('#add_depreciation').hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.res) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}

			},
			error: function (data) {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text("error");
				setTimeout(function () {
					window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
				}, 2000);
			}
		});
	});

	$("#import_tai_san_xe_may").click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		var inputimg = $('input[name=import_tai_san]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'property/import_tai_san_xe_may',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$('#add_property').hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.res) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}

			},
			error: function (data) {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text("error");
				setTimeout(function () {
					window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
				}, 2000);
			}
		});
	});

	$("#import_tai_san_o_to").click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		var inputimg = $('input[name=import_tai_san]');
		var fileToUpload = inputimg[0].files[0];
		var formData = new FormData();
		formData.append('upload_file', fileToUpload);

		$.ajax({
			enctype: 'multipart/form-data',
			url: _url.base_url + 'property/import_tai_san_oto',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$('#add_property').hide();
				$(".theloading").show();
			},
			success: function (data) {
				$(".theloading").hide();
				if (data.res) {
					$('#successModal').modal('show');
					$('.msg_success').text(data.message);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				} else {
					$("#errorModal").modal("show");
					$(".msg_error").text(data.msg);
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}

			},
			error: function (data) {
				$(".theloading").hide();
				$("#errorModal").modal("show");
				$(".msg_error").text("error");
				setTimeout(function () {
					window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
				}, 2000);
			}
		});
	});

	$('#selectAll').click(function (event) {
		if (this.checked) {
			$('.taiSanCheckBox').each(function () {
				this.checked = true;
				$('#btn-confirm-tai-san').show()
			});
		} else {
			$('.taiSanCheckBox').each(function () {
				this.checked = false;
				$('#btn-confirm-tai-san').hide()
			});
		}
	});

	$('#selectAll_phe_duyet_tai_san').click(function (event) {
		if (this.checked) {
			$('.pheDuyetTaiSanCheckBox').each(function () {
				this.checked = true;
				$('#btn-confirm-phe-duyet-tai-san').show()
			});
		} else {
			$('.pheDuyetTaiSanCheckBox').each(function () {
				this.checked = false;
				$('#btn-confirm-phe-duyet-tai-san').hide()
			});
		}
	});

	$('.taiSanCheckBox').click(function () {
		if ($('.taiSanCheckBox').is(':checked')) {
			$('#btn-confirm-tai-san').show()
			$('#selectAll').prop('checked', false)
		} else {
			$('#btn-confirm-tai-san').hide()
		}
	})
	$('.pheDuyetTaiSanCheckBox').click(function () {
		if ($('.pheDuyetTaiSanCheckBox').is(':checked')) {
			$('#btn-confirm-phe-duyet-tai-san').show()
			$('#selectAll_phe_duyet_tai_san').prop('checked', false)
		} else {
			$('#btn-confirm-phe-duyet-tai-san').hide()
		}
	})

	$('#cancel-remove-tai-san').click(function () {
		$('#selectAll').prop('checked', false)
		$('.taiSanCheckBox').each(function () {
			this.checked = false;
		});
		$('#btn-confirm-tai-san').hide()
	})
	$('#cancel-remove-phe-duyet-tai-san').click(function () {
		$('#selectAll_phe_duyet_tai_san').prop('checked', false)
		$('.pheDuyetTaiSanCheckBox').each(function () {
			this.checked = false;
		});
		$('#btn-confirm-phe-duyet-tai-san').hide()
	})

	$('#remove-tai-san').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let tai_san = [];
		$(".taiSanCheckBox:checked").each(function () {
			tai_san.push($(this).val());
		});
		var formData = new FormData();
		formData.append('tai_san', tai_san);
		formData.append('property', property);
		if (confirm('Bạn chắc chắn muốn xóa?')) {
			$.ajax({
				url: _url.base_url + 'property/delete_property',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}
			});
		}
	})

	$('#remove-phe-duyet-tai-san').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let tai_san = [];
		$(".pheDuyetTaiSanCheckBox:checked").each(function () {
			tai_san.push($(this).val());
		});
		var formData = new FormData();
		formData.append('tai_san', tai_san);
		formData.append('property', property);
		if (confirm('Bạn chắc chắn muốn bỏ duyệt?')) {
			$.ajax({
				url: _url.base_url + 'property/cancel_approve_property',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}
			});
		}
	})

	$('#confirm-phe-duyet-tai-san').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let tai_san = [];
		$(".pheDuyetTaiSanCheckBox:checked").each(function () {
			tai_san.push($(this).val());
			// console.log(tai_san);
		});
		var formData = new FormData();
		formData.append('tai_san', tai_san);
		formData.append('property', property);
		console.log(tai_san);
		// console.log(property,tab,year,type_property,phan_khuc,hang_xe,model,price)
		if (confirm('Bạn chắc chắn muốn duyệt?')) {
			$.ajax({
				url: _url.base_url + 'property/change_status_phe_duyet_tai_san',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}
			});
		}
	})

	$('#confirm-phe-duyet-khau-hao').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let khau_hao = [];
		$(".khauHaoPheDuyetCheckBox:checked").each(function () {
			khau_hao.push($(this).val());
			console.log(khau_hao);
		});
		var formData = new FormData();
		formData.append('khau_hao', khau_hao);
		formData.append('property', property);
		console.log(khau_hao);
		if (confirm('Bạn chắc chắn muốn duyệt?')) {
			$.ajax({
				url: _url.base_url + 'property/change_status_phe_duyet_khau_hao',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}
			});
		}
	})

	$('#selectAll_khau_hao').click(function (event) {
		if (this.checked) {
			$('.khauHaoCheckBox').each(function () {
				this.checked = true;
				$('#btn-confirm-khau-hao').show()
			});
		} else {
			$('.khauHaoCheckBox').each(function () {
				this.checked = false;
				$('#btn-confirm-khau-hao').hide()
			});
		}
	});
	$('#selectAll_phe_duyet_khau_hao').click(function (event) {
		if (this.checked) {
			$('.khauHaoPheDuyetCheckBox').each(function () {
				this.checked = true;
				$('#btn-confirm-phe-duyet-khau-hao').show()
			});
		} else {
			$('.khauHaoPheDuyetCheckBox').each(function () {
				this.checked = false;
				$('#btn-confirm-phe-duyet-khau-hao').hide()
			});
		}
	});

	$('.khauHaoCheckBox').click(function () {
		if ($('.khauHaoCheckBox').is(':checked')) {
			$('#btn-confirm-khau-hao').show()
			$('#selectAll_khau_hao').prop('checked', false)
		} else {
			$('#btn-confirm-khau-hao').hide()
		}
	})

	$('.khauHaoPheDuyetCheckBox').click(function () {
		if ($('.khauHaoPheDuyetCheckBox').is(':checked')) {
			$('#btn-confirm-phe-duyet-khau-hao').show()
			$('#selectAll_phe_duyet_khau_hao').prop('checked', false)
		} else {
			$('#btn-confirm-phe-duyet-khau-hao').hide()
		}
	})

	$('#cancel-remove-khau-hao').click(function () {
		$('#selectAll_khau_hao').prop('checked', false)
		$('.khauHaoCheckBox').each(function () {
			this.checked = false;
		});
		$('#btn-confirm-khau-hao').hide()
	})
	$('#cancel-remove-phe-duyet-khau-hao').click(function () {
		$('#selectAll_phe_duyet_khau_hao').prop('checked', false)
		$('.khauHaoPheDuyetCheckBox').each(function () {
			this.checked = false;
		});
		$('#btn-confirm-phe-duyet-khau-hao').hide()
	})

	$('#remove-khau-hao').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let khau_hao = [];
		$(".khauHaoCheckBox:checked").each(function () {
			khau_hao.push($(this).val());
		});
		var formData = new FormData();
		formData.append('khau_hao', khau_hao);
		formData.append('property', property);
		if (confirm('Bạn chắc chắn muốn xóa?')) {
			$.ajax({
				url: _url.base_url + 'property/delete_khau_hao',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
				}
			});
		}
	})

	$('#remove-phe-duyet-khau-hao').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let khau_hao = [];
		$(".khauHaoPheDuyetCheckBox:checked").each(function () {
			khau_hao.push($(this).val());
			console.log(khau_hao);
		});
		var formData = new FormData();
		formData.append('khau_hao', khau_hao);
		formData.append('property', property);
		console.log(khau_hao);
		if (confirm('Bạn chắc chắn muốn từ chối duyệt ?')) {
			$.ajax({
				url: _url.base_url + 'property/cancel_phe_duyet_khau_hao',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						// setTimeout(function () {
						// 	window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						// }, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					// }, 2000);
				}
			});
		}
	})
	$('#btn_approve_property').click(function (event) {
		event.preventDefault();
		let property = $("select[name='property']").val();
		let id = $(this).attr('data-id');
		let type = $(this).attr('data-type');
		let year = $(this).attr('data-year');
		let price = $(this).attr('data-price');
		let phan_khuc = $(this).attr('data-phan-khuc');
		let main_data = $(this).attr('data-main');
		let model = $(this).attr('data-model')
		let formData = new FormData();
		formData.append('id', id);
		formData.append('type', type);
		formData.append('year', year);
		formData.append('price', price);
		formData.append('main_data', main_data);
		formData.append('phan_khuc', phan_khuc);
		formData.append('model', model);
		console.log(id,type,year,price,phan_khuc,main_data);
		$.ajax({
			url: _url.base_url + 'property/approved_tai_san',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.msg);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
					setTimeout(function () {
						window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					}, 2000);
			}
		});
	});


	$('.Update_required').click(function (event){
		event.preventDefault();
		let property = $("select[name='property']").val()
		let tab = $("input[name='tab']").val()
		let price_update = $("input[name='price']").val();
		let id_update = $(".id_update").val();
		console.log(id_update,price_update);
		let formData = new FormData();
		formData.append('price',price_update);
		formData.append('id',id_update)
			var price_str = $('.gia_xe').text();
			var price = price_str.split(',').join('')
			var price_input = $('.price_edit').val();
			if (price_input == price || price_update == ""){
				$("#errorModal").modal("show");
			}
			else{
				$.ajax({
			url: _url.base_url + 'property/update_price_property',
			type: "POST",
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			beforeSend: function () {
				$(".theloading").show();
			},
			success: function (data) {
				console.log(data)
					$(".theloading").hide();
					if (data.code == 200) {
						$('#successModal').modal('show');
						$('#show_info_item').hide();
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$('#show_info_item').hide();
						$(".msg_error").text(data.msg);
						// setTimeout(function () {
						// 	window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
						// }, 2000);
					}
				},
				error: function () {
					$(".theloading").hide();
					$('#show_info_item').hide();
					console.log('error')
					// setTimeout(function () {
					// 	window.location.href = _url.base_url + 'property?tab=' + tab + "&property=" + property;
					// }, 2000);
			}
		});
			}

	});


});


