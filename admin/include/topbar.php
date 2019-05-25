<div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="./index.php">
                <img src="./demo/brand/brand.png" class="header-brand-img" alt="tabler logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(./demo/administrator.png)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php echo $fullname; ?></span>
                      <small class="text-muted d-block mt-1">Administrator</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="#">
                      <span class="float-right"><span class="badge badge-primary">6</span></span>
                      <i class="dropdown-icon fe fe-mail"></i> Inbox
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-send"></i> Message
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="logout.php">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-3 ml-auto">
                <form class="input-icon my-3 my-lg-0">
                  <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
                  <div class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </div>
                </form>
              </div>
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="./index.php" class="nav-link"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <!-- <li class="nav-item">
                    <a href="./index.php" class="nav-link"><i class="fe fe-calendar"></i> Attendance</a>
                  </li> -->
                  <li class="nav-item">
                    <a href="./class_management.php" class="nav-link"><i class="fe fe-package"></i> Class</a>
                  </li>
                  <li class="nav-item">
                    <a href="./students.php" class="nav-link"><i class="fe fe-users"></i> Students</a>
                  </li>
                  <li class="nav-item">
                    <a href="./index.php" class="nav-link"><i class="fe fe-home"></i> Teacher</a>
                  </li>
                   <li class="nav-item">
                    <a href="./grade_section.php" class="nav-link"><i class="fe fe-home"></i> Grade & Section</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>