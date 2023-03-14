<div class="col-xs-12 p-0">
			<div class="x_panel">
				<div class="x_title">
					
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<ul class="list-unstyled timeline workflow widget">
						<?php if (!empty($logs)) {
							foreach ($logs as $key => $wl) {


								?>
								<li>
									<img class="theavatar"
										 src="<?php echo base_url("assets/imgs/avatar_none.png") ?>"
										 alt="">
									<div class="block">
										<div class="block_content">
											<h2 class="title">
												<a style="font-size: 14px"><?= !empty($wl->action) ? $wl->action : ""; ?></a>
											</h2>
											<div class="byline">
												<p>
<!--													<strong>--><?php //echo !empty($wl->created_at) ? date('d/m/Y H:i:s', intval($wl->created_at) + 7 * 60 * 60) : "" ?><!--</strong>-->
													<strong><?php echo !empty($wl->created_at) ? date('d/m/Y H:i:s',$wl->created_at) : "" ?></strong>
												</p>
												<p>By:
													<a><?php echo !empty($wl->created_by) ? ($wl->created_by) : '' ?></a>
												</p>
												<!-- <p>To: <a>Smith Jane</a></p> -->
											</div>
											<div class="excerpt">

												<p><?php echo !empty($wl->new->note) ? $wl->new->note : '' ?></p>


												<?php if (!empty($wl->new->exception1_value_detail[0])): ?>

													<?php foreach ($wl->new->exception1_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 1): ?>
															<p><?php echo "E1.1: Ngoại lệ về tuổi vay" ?></p>
														<?php elseif ($value_detail == 2): ?>
															<p><?php echo "E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->exception2_value_detail[0])): ?>

													<?php foreach ($wl->new->exception2_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 3): ?>
															<p><?php echo "E2.1: Khách hàng KT3 tạm trú dưới 6 tháng" ?></p>
														<?php elseif ($value_detail == 4): ?>
															<p><?php echo "E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác minh qua chủ nhà trọ" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->exception3_value_detail[0])): ?>
													<?php foreach ($wl->new->exception3_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 5): ?>
															<p><?php echo "E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->exception4_value_detail[0])): ?>

													<?php foreach ($wl->new->exception4_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 6): ?>
															<p><?php echo "E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của công ty (đất, giấy tờ khác...)" ?></p>
														<?php elseif ($value_detail == 7): ?>
															<p><?php echo "E4.2: Ngoại lệ về lãi suất sản phẩm" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->exception5_value_detail[0])): ?>

													<?php foreach ($wl->new->exception5_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 8): ?>
															<p><?php echo "E5.1: Ngoại lệ về điều kiện đối với người tham chiếu" ?></p>
														<?php elseif ($value_detail == 9): ?>
															<p><?php echo "E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống phonet" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->exception6_value_detail[0])): ?>
													<?php foreach ($wl->new->exception6_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 10): ?>
															<p><?php echo "E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng khác" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->exception7_value_detail[0])): ?>

													<?php foreach ($wl->new->exception7_value_detail[0] as $value_detail): ?>
														<?php if ($value_detail == 11): ?>
															<p><?php echo "E7.1: Khách hàng vay lại có lịch sử trả tiền tốt" ?></p>
														<?php elseif ($value_detail == 12): ?>
															<p><?php echo "E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp" ?></p>
														<?php elseif ($value_detail == 13): ?>
															<p><?php echo "E7.3: KH làm việc tại các công ty là đối tác chiến lược" ?></p>
														<?php elseif ($value_detail == 14): ?>
															<p><?php echo "E7.4: Giá trị định giá tài sản cao" ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>




												<?php if (!empty($wl->new->lead_cancel1_C1[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C1[0] as $value): ?>
														<?php if ($value == "C1.1"): ?>
															<p><?php echo 'Nhập thiếu/sai thông tin trên hệ thống' ?></p>
														<?php elseif ($value == "C1.2"): ?>
															<p><?php echo 'Khách hàng đang có tiền án tiền sự' ?></p>
														<?php elseif ($value == "C1.3"): ?>
															<p><?php echo 'Khách hàng không biết chữ' ?></p>
														<?php elseif ($value == "C1.4"): ?>
															<p><?php echo 'CMND/CCCD/HC có số bị in đè - CMND/CCCD có dấu hiệu nghi ngờ bóc tách, thay ảnh - CMND/CCCD mờ số hoặc mờ ảnh hoàn toàn không nhận diện được' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!empty($wl->new->lead_cancel1_C2[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C2[0] as $value): ?>
														<?php if ($value == "C2.1"): ?>
															<p><?php echo 'KH không sống tại địa chỉ kê khai' ?></p>
														<?php elseif ($value == "C2.2"): ?>
															<p><?php echo 'KH cố tình cung cấp sai địa chỉ, thông tin nơi ở, tạm trú' ?></p>
														<?php elseif ($value == "C2.2"): ?>
															<p><?php echo 'KH cố tình cung cấp sai địa chỉ, thông tin nơi ở, tạm trú' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!empty($wl->new->lead_cancel1_C3[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C3[0] as $value): ?>
														<?php if ($value == "C3.1"): ?>
															<p><?php echo 'KH không sống tại địa chỉ kê khai' ?></p>
														<?php elseif ($value == "C3.2"): ?>
															<p><?php echo 'KH cố tình cung cấp sai địa chỉ, thông tin nơi ở, tạm trú' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!empty($wl->new->lead_cancel1_C4[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C4[0] as $value): ?>
														<?php if ($value == "C4.1"): ?>
															<p><?php echo 'Tài sản quá cũ so với thời gian trên giấy tờ' ?></p>
														<?php elseif ($value == "C4.2"): ?>
															<p><?php echo 'Giá trị tài sản quá thấp' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!empty($wl->new->lead_cancel1_C5[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C5[0] as $value): ?>
														<?php if ($value == "C5.1"): ?>
															<p><?php echo 'Giả mạo người thân của KH để cung cấp thông tin' ?></p>
														<?php elseif ($value == "C5.2"): ?>
															<p><?php echo 'Thông tin thu thập không đúng như KH kê khai' ?></p>
														<?php elseif ($value == "C5.3"): ?>
															<p><?php echo 'Người tham chiếu cung cấp sai thông tin / không thể cung cấp được thông tin' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!empty($wl->new->lead_cancel1_C6[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C6[0] as $value): ?>
														<?php if ($value == "C6.1"): ?>
															<p><?php echo 'KH có lịch sử vay quá hạn xấu tại VFC' ?></p>
														<?php elseif ($value == "C6.2"): ?>
															<p><?php echo 'KH có số lượng khoản vay app online vượt quá quy định, PGD không có ngoại lệ hoặc không đủ điều kiện ngoại lệ' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php if (!empty($wl->new->lead_cancel1_C7[0])): ?>
													<?php foreach ($wl->new->lead_cancel1_C7[0] as $value): ?>
														<?php if ($value == "C7.1"): ?>
															<p><?php echo 'Nghi ngờ giấy tờ/thông tin KH giả mạo' ?></p>
														<?php elseif ($value == "C7.2"): ?>
															<p><?php echo 'Sai khác thông tin trên hồ sơ và chứng từ' ?></p>
														<?php elseif ($value == "C7.3"): ?>
															<p><?php echo 'KH không bổ sung được hồ sơ theo yêu cầu của TĐV' ?></p>
														<?php elseif ($value == "C7.4"): ?>
															<p><?php echo 'KH không còn nhu cầu vay' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>


												<?php if (!empty($wl->new->error_code[0])): ?>
													<?php foreach ($wl->new->error_code[0] as $value): ?>
														<?php if ($value == "B1"): ?>
															<p><?php echo 'Nhập thiếu/sai thông tin trên hệ thống' ?></p>
														<?php elseif ($value == "B2"): ?>
															<p><?php echo 'Bổ sung giấy tờ/thông tin (khác) theo quy định sản phẩm' ?></p>
														<?php elseif ($value == "B3"): ?>
															<p><?php echo 'SĐT KH, NTC chưa liên hệ được / chưa đúng / từ chối cc thông tin hoặc chưa đủ' ?></p>
														<?php elseif ($value == "B4"): ?>
															<p><?php echo 'Bổ sung thông tin thiết bị định vị tài sản' ?></p>
														<?php elseif ($value == "B5"): ?>
															<p><?php echo 'Trả về theo yêu cầu PGD' ?></p>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>

												<?php if (!empty($wl->new->reason)): ?>
													<?php if ($wl->new->reason == 1): ?>
														<p><?php echo "Đầy đủ điều kiện theo quy định" ?></p>
													<?php elseif ($wl->new->reason == 2): ?>
														<p><?php echo "Đáp ứng được điều kiện ngoại lệ" ?></p>
													<?php elseif ($wl->new->reason == 3): ?>
														<p><?php echo "Đánh giá để giảm số tiền vay" ?></p>
													<?php endif; ?>
												<?php endif; ?>

												<?php if (!empty($wl->action)) {
													$old_status = contract_status($wl->old->status);
													$new_status = contract_status($wl->new->status);
													$old_status = is_array($old_status) ? '' : $old_status;
													$new_status = is_array($new_status) ? '' : ' => ' . $new_status;
													$status_detail = $old_status . $new_status;
													?>
													<p>
														<?= $status_detail ?>
													</p>

													<?php if (!empty($wl->new->image_file)) { ?>
														<div class="row">
															<?php foreach ((array)$wl->new->image_file as $key => $value) { ?>

																<?php if ($value->file_type == 'image/png' || $value->file_type == 'image/jpg' || $value->file_type == 'image/jpeg') { ?>
																	<div class="col-xs-12 col-md-6 col-lg-3">
																		<a href="<?= $value->path ?>"
																		   class="magnify_item"
																		   data-magnify="gallery"
																		   data-src="" data-group="thegallery"
																		   data-gallery="uploads_agree"
																		   data-max-width="992" data-type="image"
																		   data-title="Hồ sơ bổ sung/trả về">
																			<img style="height: 75px"
																				 name="img_contract"
																				 data-key="<?= $key ?>"
																				 data-fileName="<?= $value->file_name ?>"
																				 data-fileType="<?= $value->file_type ?>"
																				 data-type='agree'
																				 src="<?= $value->path ?>" alt="">
																		</a>
																	</div>

																<?php } ?>

																<?php if ($value->file_type == 'application/pdf') { ?>
																	<div class="col-xs-12 col-md-6 col-lg-3">
																		<a href="<?= $value->path ?>" target="_blank">
																			<img style="height: 75px" src="https://service.tienngay.vn/uploads/avatar/1635914192-d53bb9271d4a70e6607451aca8fd5a3e.png" alt="">
																		</a>
																	</div>
																<?php } ?>

																<?php if ($value->file_type == 'video/mp4') : ?>
																	<div class="col-xs-12 col-md-6 col-lg-3">
																		<a href="<?= $value->path ?>" target="_blank">
																			<img style="height: 75px" src="https://service.tienngay.vn/uploads/avatar/1658829094-61b2e51dffce7ee7c202116bfe011f77.jpg" alt="logo_mp4">
																		</a>
																	</div>
																<?php endif; ?>

															<?php } ?>



														</div>
													<?php }
												} ?>

											</div>
										</div>
									</div>
								</li>
								<?php
							}
						} ?>
					</ul>
				</div>
			</div>
		</div>
