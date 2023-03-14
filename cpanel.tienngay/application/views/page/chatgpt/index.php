<style type="text/css">
img{ max-width:100%;}


.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
/*  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;*/
  padding: 30px 15px 0 25px;
  width: 100%;
  max-width: 700px;
  overflow-y: auto;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 5px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write textarea {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
.hidden {
	display: none;
}

textarea:focus {
    border: medium none;
}
#hook {
	padding-top: 20px;
}
</style>
<div class="right_col" role="main">
	<div class="mesgs">
      <div id="msg_history" class="msg_history">
        <div class="incoming_msg">
          <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
          <div class="received_msg">
            <div class="received_withd_msg">
               <p>Chào bạn, hãy hỏi tôi câu hỏi bất kỳ. Tôi sẽ cố gắng trả lời!</p>
              <span class="time_date">/span></div>
          </div>
        </div>

        <div id="hook">
        </div>

      </div>
      <div id="typing" class="hidden">
      	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; display: block;" width="100px" height="70px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
			<g transform="translate(20 50)">
			<circle cx="0" cy="0" r="6" fill="#e15b64">
			  <animateTransform attributeName="transform" type="scale" begin="-0.3440366972477064s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="0.9174311926605504s" repeatCount="indefinite"></animateTransform>
			</circle>
			</g><g transform="translate(40 50)">
			<circle cx="0" cy="0" r="6" fill="#f8b26a">
			  <animateTransform attributeName="transform" type="scale" begin="-0.2293577981651376s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="0.9174311926605504s" repeatCount="indefinite"></animateTransform>
			</circle>
			</g><g transform="translate(60 50)">
			<circle cx="0" cy="0" r="6" fill="#abbd81">
			  <animateTransform attributeName="transform" type="scale" begin="-0.1146788990825688s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="0.9174311926605504s" repeatCount="indefinite"></animateTransform>
			</circle>
			</g><g transform="translate(80 50)">
			<circle cx="0" cy="0" r="6" fill="#81a3bd">
			  <animateTransform attributeName="transform" type="scale" begin="0s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="0.9174311926605504s" repeatCount="indefinite"></animateTransform>
			</circle>
			</g>
			</svg>
      </div>
      <div class="type_msg">
        <div class="input_msg_write">
          <textarea id="msg-content" type="text" class="write_msg" placeholder="Type a message" ></textarea>
          <button id="send-mgs" class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
</div>

<div id="incomming-msg" class="incoming_msg hidden">
  <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
  <div class="received_msg">
    <div class="received_withd_msg">
      <p id="msg-text"></p>
      <span class="time_date"></span></div>
  </div>
</div>

<div id="outgoing-msg" class="outgoing_msg hidden">
  <div class="sent_msg">
    <p id="msg-text"></p>
    <span class="time_date"></span> </div>
</div>

<script type="text/javascript">

	/**
     * Service upload file
     * */
    const sendMsg = async function (data, callback) {
        $("#typing").removeClass('hidden');
        let url = "<?php echo $url;?>";
        const response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                // 'x-csrf-token': csrf,
                "Content-Type": "application/json",
                Accept: "application/json",
            }
        });
        const result = await response.json();
        callback(result);
        $("#typing").addClass('hidden');
    }


	$( document ).ready(function() {
		$('.time_date').text(new Date().toLocaleString());
		$("#send-mgs").on('click', function () {
			let s = new Date().toLocaleString();
			function callback (result) {
				if (result.code == 200) {
					let msg = result.msg;
					let incomming = $("#incomming-msg").clone(true);
					incomming.removeClass('hidden');
					incomming.find("#msg-text").text(msg);
					incomming.find("#msg-text").html(incomming.find("#msg-text").html().replace(/\n/g,'<br/>'));
					incomming.find(".time_date").text(s);
					$("#hook").before($(incomming));
				} else {
					let incomming = $("#incomming-msg").clone(true);
					incomming.removeClass('hidden');
					incomming.find("#msg-text").text("error");
					incomming.find("#msg-text").html(incomming.find("#msg-text").html().replace(/\n/g,'<br/>'));
					incomming.find(".time_date").text(s);
					$("#hook").before($(incomming));
				}

				var elem = document.getElementById('msg_history');
  				elem.scrollTop = elem.scrollHeight;
				
			}
			let msg = $("#msg-content").val();
			$("#msg-content").val("");
			let outgoing = $("#outgoing-msg").clone(true);
			outgoing.removeClass('hidden');
			outgoing.find("#msg-text").text(msg);
			outgoing.find(".time_date").text(s);
			outgoing.find("#msg-text").html(outgoing.find("#msg-text").html().replace(/\n/g,'<br/>'));
			$("#hook").before($(outgoing));
			var elem = document.getElementById('msg_history');
  			elem.scrollTop = elem.scrollHeight;
			sendMsg({msg : msg}, callback);
		});
	});	
</script>
