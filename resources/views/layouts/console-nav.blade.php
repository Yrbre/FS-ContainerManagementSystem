<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex bg-white border p-3">
        <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid w-100" style="max-width: 100px" alt="BagiBagi Logo">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('console.dashboard') }}">
                <span class="material-icons me-2">dashboard</span> Dashboard
            </a>
        </li>
        @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Finance Staff', 'Purchasing', 'Site Manager'])
            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <span class="material-icons me-2">folder</span> Master</a>
                <ul class="nav-group-items">
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Purchasing', 'Site Manager'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.container.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Kontainer
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator', 'Supervisor'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('console.admin.index')}}">
                                <span class="material-icons mr-2">fiber_manual_record</span> User
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator', 'Supervisor', 'Manager', 'Finance Staff', 'Purchasing', 'Site Manager'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.contract.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Kontrak
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.location.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Lokasi
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.vendor.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Vendor
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.company.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Perusahaan
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.unit.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Satuan
                            </a>
                        </li>
                    @endcan
                    @can(['Administrator'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('console.config.index') }}">
                                <span class="material-icons mr-2">fiber_manual_record</span> Config
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Site Manager'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('console.inspection.index') }}">
                    <span class="material-icons me-2">check</span> Inspeksi
                </a>
            </li>
        @endcan

        @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Site Manager'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('console.container-daily-activity.index') }}">
                    <span class="material-icons me-2">border_color</span> Aktivitas Harian CT
                </a>
            </li>
        @endcan

        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <span class="material-icons me-2">rotate_90_degrees_ccw</span> Serah Terima CT
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Finance', 'Site Manager'])
                        <a class="nav-link" href="{{ route('console.delegation-to-vendor.index') }}">
                            <span class="material-icons me-2">fiber_manual_record</span> Ke Vendor
                        </a>
                    @endcan
                    @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Site Manager'])
                        <a class="nav-link" href="{{ route('console.delegation-from-vendor.index') }}">
                            <span class="material-icons me-2">fiber_manual_record</span> Dari Vendor
                        </a>
                    @endcan
                </li>
            </ul>
        </li>

        @can(['Administrator', 'Checker', 'Supervisor', 'Manager', 'Site Manager'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('console.container-repair.index') }}">
                    <span class="material-icons me-2">trending_up</span> Progress Perbaikan
                </a>
            </li>
        @endcan

        @can(['Administrator', 'Supervisor', 'Manager', 'Site Manager'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('console.container-scrap.index') }}">
                    <span class="material-icons me-2">recycling</span> Proses Scrap CT
                </a>
            </li>
        @endcan
        
        @can(['Checker', 'Manager', 'Supervisor', 'Finance', 'Finance Staff', 'Purchasing', 'Site Manager'])
            <li class="nav-group">
                <a class="nav-link nav-group-toggle" href="#">
                    <span class="material-icons me-2">receipt_long</span> Laporan
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('console.report.container-dashboard') }}">
                            <span class="material-icons me-2">fiber_manual_record</span> CT Dashboard
                        </a>
                        <a class="nav-link" href="{{route('console.report.container-status-report')}}">
                            <span class="material-icons me-2">fiber_manual_record</span> CT Report
                        </a>
                        <a class="nav-link" href="{{ route('console.bast.maintenance') }}">
                            <span class="material-icons me-2">fiber_manual_record</span>Rekap BAST
                        </a>
                        <a class="nav-link" href="{{ route('console.report.container-record') }}">
                            <span class="material-icons me-2">fiber_manual_record</span>CT History
                        </a>
                        <a class="nav-link" href="{{ route('console.bast.inspection') }}">
                            <span class="material-icons me-2">fiber_manual_record</span>Rekap Inspeksi
                        </a>
                        {{-- <a class="nav-link nav-group-toggle" href="#">
                            <span class="material-icons me-2">fiber_manual_record</span> BAST Report
                        </a>
                        <ul class="nav-group-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('console.bast.maintenance') }}">
                                    <span class="material-icons me-2">fiber_manual_record</span> Maintenance
                                </a>
                                <a class="nav-link" href="{{ route('console.bast.upgrade') }}">
                                    <span class="material-icons me-2">fiber_manual_record</span> Upgrade
                                </a>
                            </li>
                        </ul> --}}
                        {{-- <a class="nav-link" href="#">
                            <span class="material-icons me-2">fiber_manual_record</span> Rekap BAST Report
                        </a> --}}
                    </li>
                </ul>
            </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link" href="{{ route('console.download.user-manual') }}">
                <span class="material-icons me-2">download</span> Download User Manual 
            </a>
        </li>
    
    </ul>
</div>
