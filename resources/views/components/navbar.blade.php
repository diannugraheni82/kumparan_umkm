<nav class="navbar navbar-expand-lg navbar-mitra sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="brand-logo" href="/mitra/dashboard">
                KUMPARAN<span class="text-primary">.</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item me-2">
                        <a class="nav-link " href="http://127.0.0.1:8000/mitra/eksplorasi">
                            <i class="bi bi-people me-1"></i> Partner Saya
                        </a>
                    </li>

                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle " href="#" id="eventDrop" data-bs-toggle="dropdown">
                            <i class="bi bi-calendar-event me-1"></i> Event Saya
                        </a>
                        <ul class="dropdown-menu shadow">
                            <li>
                                <a class="dropdown-item" href="http://127.0.0.1:8000/mitra/events/create">
                                    <i class="bi bi-plus-circle me-2"></i>Buat Event Baru
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="http://127.0.0.1:8000/mitra/events">
                                    <i class="bi bi-card-list me-2"></i>Daftar Event
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle hide-arrow position-relative p-0" href="#" id="notifDropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                                                                                </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden" style="width: 300px;">
                            <li class="bg-light px-3 py-2 fw-bold border-bottom small">Notifikasi</li>
                            <div style="max-height: 300px; overflow-y: auto;">
                                                                    <li class="text-center py-4 text-muted small">Tidak ada notifikasi</li>
                                                            </div>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDrop" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: 700; font-size: 0.8rem;">
                                D
                            </div>
                            <span class="fw-bold d-none d-md-inline">dian</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/profile"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="http://127.0.0.1:8000/logout">
                                    <input type="hidden" name="_token" value="3ZamVjHEtxxkPxlwlUzMdrs3zORI3EmAc2zihawd" autocomplete="off">                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>