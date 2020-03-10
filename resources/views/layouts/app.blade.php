<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lineage</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="/bower_components/jquery-ui/themes/base/jquery-ui.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .dataTables_filter
    ,.dataTables_paginate{
      float: right;
    }

    th,td{
       text-align:center;"
    }

  .index_div {
    padding: 30px
    width:100%;
  
  }


  </style>





</head>





<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper" style="min-height:800px">

    <header class="main-header">
      <!-- Logo -->
      <a href="{{url('')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">Lineage</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>天堂</b>Management</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
             
           
            @if(Auth::user())
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="/dist/img/user-def.png" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="/dist/img/user-def.png" class="img-circle" alt="User Image">

                  <p>
                    Lineage Manager - Web Developer
                    <small>Member since Apr. 2018</small>
                  </p>
                </li>
              
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{url('user/change-password')}}" class="btn btn-default btn-flat">變更密碼</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{url('logout')}}" class="btn btn-default btn-flat">登出</a>
                  </div>
                </li>
              </ul>
            </li>
            @endif
          
           
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    @if(Auth::user())
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
       
        <div class="user-panel">
          <h3 class="row" style="margin: 0px;text-align: center;color: white;">
              {{Auth::user()->customer->username}}
          </h3>

          <div class="pull-left image">
            <img src="/dist/img/user-def.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <div class="pull-left image">
      		    <p>{{ Auth::user()->name }}</p>
              <i class="fa fa-circle text-success"></i> Online
            </div>
          </div>
        </div>
        
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Workspace</li>
  		@if(strpos(Auth::user()->role_id, '3') !== false)
      <li>
        <a href="{{url('user/create-user')}}">
        <i class="fa fa-cogs"></i> <span>建立帳號</span>
        </a>
      </li>
      @endif
      @if(strpos(Auth::user()->role_id, '3') !== false)
  		<li>
        <a href="{{url('role/authority-view')}}">
  			<i class="fa fa-cogs"></i> <span>權限設定</span>
  		  </a>
      </li>
      @endif
       <li>
        <a href="{{url('guild/index')}}">
        <i class="fa fa-cogs"></i> <span>公會成員設定</span>
        </a>
      </li> 
        @if(strpos(Auth::user()->role_id, '4') !== false)
        <li>
          <a href="{{url('import/index')}}">
          <i class="fa fa-cogs"></i> <span>入帳作業</span>
          </a>
    		</li>

        <li>
          <a href="{{url('export/index')}}">
          <i class="fa fa-cogs"></i> <span>提領審核</span>
          </a>
        </li>
        
        <li>
          <a href="{{url('offset/index')}}">
          <i class="fa fa-cogs"></i> <span>扣薪入帳審核</span>
          </a>
        </li>
        <li>
          <a href="{{url('publicmoney/index')}}">
          <i class="fa fa-cogs"></i> <span>公積金管理</span>
          </a>
        </li>
        @endif
       @if(strpos(Auth::user()->role_id, '3') !== false)
      <li>
        <a href="{{url('general/index')}}">
        <i class="fa fa-cogs"></i> <span>金庫總覽</span>
        </a>
      </li>
<!--
      <li>
        <a href="{{url('salary/index')}}">
        <i class="fa fa-cogs"></i> <span>清算中心</span>
        </a>
      </li>
-->
      @endif



      



    


     <!--  <li>
        <a href="{{url('report/index')}}">
        <i class="fa fa-credit-card"></i> <span>扣薪入帳(TEST)</span>
        </a>
      </li> -->
    
     <!--
      <li>
        <a href="#">
        <i class="fa fa-th"></i> <span>個人銀行</span>
      
        </a>
      </li>
      <li>
        <a href="#">
        <i class="fa fa-th"></i> <span>寶物申報</span>
      
        </a>
      </li>
    
      <li>
        <a href="{{url('rank/index')}}">
        <i class="fa fa-trophy"></i> <span>積分表</span>
        </a>
      </li>
   
-->
      <li>
        <a href="{{url('report/index')}}">
        <i class="fa fa-bar-chart"></i> <span>聯盟收入</span>
        </a>
      </li>
      <li>
        <a href="{{url('treasure/index')}}">
        <i class="fa fa-balance-scale"></i> <span>寶物申報</span>
        </a>
      </li>
      <li>
        <a href="{{url('killer/index')}}">
        <i class="fa fa-gavel"></i> <span>出草申報</span>
        </a>
      </li>

      <!--
      <li>
        <a href="{{url('question/index')}}">
        <i class="fa fa-question"></i> <span>問卷調查</span>
        </a>
      </li>
    -->
      <li>
        <a href="{{url('auction/index')}}">
        <i class="fa fa-money"></i> <span>拍賣場</span>
        </a>
      </li>
      <li>
        <a href="{{url('self/index')}}">
        <i class="fa fa-id-card-o"></i> <span>個人銀行</span>
        </a>
      </li>

      @if(strpos(Auth::user()->role_id, '6') !== false)
      <li>
        <a href="{{url('deposit/index')}}">
        <i class="fa fa-money"></i> <span>儲值功能</span>
        </a>
      </li>
      @endif


       





    
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
    @endif


    <section class="content-wrapper">
        @yield('content')
        @if(Request::is('/'))
       
          <section class="content-header">
              <h1>
                <small>首頁</small>
              </h1>
          </section>

          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-body">
                    <div class="index_div">
                      <img style="width: 100%;max-height: 6750px;max-width: 1200px;" src='/assets/img/lineageM.jpg'>
                      <h4>其他連結</h4>
                      <ol>
                        <li><a href='https://drive.google.com/file/d/1Ld7wD9pFArW-olvjSQrzbtRBFvuwW4kG/view?usp=sharing' target='_blank'>系統教學文件</a></li>
                        <!-- <li><a href='https://www.evernote.com/shard/s524/sh/da534e71-f9b8-4b99-b804-ed8946ff4b00/04eaa236501539a6' target='_blank'>聯盟協議事項</a></li> -->
                        <li><a href='https://docs.google.com/document/d/1H_e_By9DTEAa0VYfwoE-Nm6ZZmHymgqjwGO1mMPuYtM/edit' target='_blank'>虛擬搖桿點人教學</a></li>
                      </ol>
                    </div>
                   
                      
                 
                  </div>
                </div>
              </div>
            </div>
          </section>

        @endif



    </section>
  </div>



    <!-- Control Sidebar -->
 
  <div class="control-sidebar-bg">
  </div>

  <div id="ajax-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      @include('layouts.modal')
    </div>
  </div>
  
	<!--JS-->
		<!-- jQuery 3 -->
		<script src="/bower_components/jquery/dist/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	
		<!-- Bootstrap 3.3.7 -->
		<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Morris.js charts -->
		<script src="/bower_components/raphael/raphael.min.js"></script>
		<script src="/bower_components/morris.js/morris.min.js"></script>
		<!-- Sparkline -->
		<script src="/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
		<!-- jvectormap -->
		<script src="/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
		<!-- daterangepicker -->
		<script src="/bower_components/moment/min/moment.min.js"></script>
		<script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- datepicker -->
		<script src="/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="/bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="/dist/js/adminlte.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
	<!--JS-->	
    <script>
    function tag(i) {
        $('html,body').animate({scrollTop:$(".box-title").eq(i).offset().top-70},500); 
    }
    function gotop() {
        $('html,body').animate({scrollTop:0},500);  
    }
    function click_all(obj)
    {
      if($(obj).is(':checked'))
      {
        $('form input[type="checkbox"]').prop('checked', true);
      }
      else
      {
        $('form input[type="checkbox"]').prop('checked', false);
      }
    }

    $("[data-target='#ajax-modal']").click(function(ev) {
        ev.preventDefault();
        var target = $(this).attr("href");

        // load the url and show modal on success
        $("#ajax-modal").load(target, function() { 
             $("#ajax-modal").modal("show"); 
        });
    });
    </script>
    @yield('script')
</body>
</html>
