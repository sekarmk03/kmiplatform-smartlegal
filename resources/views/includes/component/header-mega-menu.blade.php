<!-- BEGIN navbar-collapse -->
<div class="collapse d-md-block me-auto" id="top-navbar">
  <div class="navbar-nav">
    <div class="navbar-item dropdown dropdown-lg">
      <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
      <i class="fa fa-solid fa-desktop fa-fw me-1"></i> 
      <span class="d-lg-inline d-md-none">Application</span>
      <b class="caret ms-1"></b>
      </a>
      <div class="dropdown-menu dropdown-menu-lg">
        <div class="row">
          @php
              $modules = App\Models\DepartmentModel::departmentModule();
          @endphp
          @foreach ($modules as $item)
          <div class="col-lg">
            <div class="h5 fw-bolder mb-2">{{ $item['department'] }}</div>
            <div class="row mb-3">
              <div class="col-lg-6">
                <ul class="nav d-block fw-bold">
                  @foreach ($item['modules'] as $row)                      
                    <li><a href="/{{ strtolower($row['module']) }}" class="text-ellipsis text-dark text-decoration-none"><i class="fa fa-chevron-right fa-fw text-gray-500"></i> {{ $row['module'] }}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>              
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END navbar-collapse -->