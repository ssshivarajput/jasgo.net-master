	<link rel="Shortcut Icon" href="favicon.png" type="image/x-png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="//code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
	
	
	<script type="text/javascript">
 function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>
   
<script type="text/javascript">
$('document').ready(function(){
$("#selectall").click(function () {
$('.td').attr('checked', this.checked);
});
$(".td").click(function(){
if($(".td").length == $(".td:checked").length) {
$("#selectall").attr("checked", "checked");
} else {
$("#selectall").removeAttr("checked");
}
});
});
</script>
	 <script>
function popupCenter(url, title, w, h) {
  var left = 0;
  var top = 0;
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>	
<style type="text/css">
.imgresponsive{max-width:100%!important;}
.image img {max-width:100%!important;}
#tblData{border:1px solid #CCCCCC; border-collapse:collapse;}
.ck-content{ font-size:14px;line-height:20px;}

div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	
		color: #DDD;
	}

.stylend {
	color: #FF3300;
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
	padding-left:400px;
}

/* ::-webkit-scrollbar { width: 7px; height: 3px;}
.webkit-scrollbar-button {  background-color: #999; border-radius: 10px; }
::-webkit-scrollbar-track {  background-color: #F8F8F8;}
::-webkit-scrollbar-track-piece { background-color: #F8F8F8;}
::-webkit-scrollbar-thumb { height: 50px; background-color: #999; border-radius: 10px;}
::-webkit-scrollbar-corner { background-color: #F8F8F8;}
::-webkit-resizer { background-color: #999;}
 .theader{font-size:14px; color:#000; font-weight:bold; text-transform:uppercase;}*/
	.tcontent{font-size:14px; color:#000;}
	.tcontent:hover{ background:#CCFFD9;}
	.tcontentq{font-size:12px; color:#000;}
	.message{font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#f00; font-style:italic;}
 
 .wrapword {
    white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
    white-space: -webkit-pre-wrap;          /* Chrome & Safari */ 
    white-space: -pre-wrap;                 /* Opera 4-6 */
    white-space: -o-pre-wrap;               /* Opera 7 */
    white-space: pre-wrap;                  /* CSS3 */
    word-wrap: break-word;                  /* Internet Explorer 5.5+ */
    word-break: break-all;
    white-space: normal;
}
  @media (max-width: 480px) { .hidem{ display: none; visibility:hidden;} } </style>