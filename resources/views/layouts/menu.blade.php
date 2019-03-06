
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                   
                        <div class="user-img-div">
                            <div class="inner-text">
                                 {{ Auth::user()->name }} 
                            </div>
                        </div>

                  
					<li>
					  <a href="pages/widgets.html">
						<i class="fa fa-th"></i> <span>權限設定</span>
						<span class="pull-right-container">
						  <small class="label pull-right bg-green">new</small>
						</span>
					  </a>
					</li>
					

                    <li>
                        <a href="table.html"><i class="fa fa-flash "></i>建檔作業</a>
                        
                    </li>
                    
                    <li>
                        <a href="gallery.html"><i class="fa fa-anchor "></i>業務作業</a>
                    </li>
                    <li>
                        <a href="error.html"><i class="fa fa-bug "></i>審核作業</a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-bicycle "></i>不可開發審核</a>
                            </li>
                             <li>
                                <a href="#"><i class="fa fa-flask "></i>送件過後審核</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="login.html"><i class="fa fa-sign-in "></i>歸檔作業</a>
                    </li>
                    <li>
                        <a href="blank.html"><i class="fa fa-square-o "></i>離職交接作業</a>
                    </li>

                    <li>
                        <a href="blank.html"><i class="fa fa-square-o "></i>查詢與報表</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>登出</a>
                    </li>
                </ul>

            </div>
