<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{ auth()->user()->uid }}</h3>
        <a href="javascript:" class="btn btn-xs btn-icon btn-light btn-hover-danger" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <div class="offcanvas-content pr-5 mr-n5">
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url({{ asset('img/user.jpg') }})"></div>
            </div>
            <div class="d-flex flex-column">
                <a href="javascript:" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ auth()->user()->uid }}</a>
            </div>
        </div>
        <div class="separator separator-dashed mt-8 mb-5"></div>
    </div>
</div>
