<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <li class="menu-item menu-item-here menu-item-rel" aria-haspopup="true">
                        <button class="menu-link btn-dark">
                            <span class="menu-text text-light">{{ now()->format('n.j.Y H:i') }}</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="topbar">
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ name() }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-dark">
                        <span class="symbol-label font-size-h5 font-weight-bold">{{ name(true) }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
