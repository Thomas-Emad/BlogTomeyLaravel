<style>
    .cookies-popup {
        transition: 0.3s;
        animation: show_popup 1.5s linear 5s 1 forwards;
        width: 50%;
        left: -200%;
    }

    @media (max-width: 768px) {
        .cookies-popup {
            width: 90%;
        }
    }

    @keyframes show_popup {
        0% {
            left: -200%;
            opacity: 0;
        }

        100% {
            left: 10px;
            opacity: 1;
        }
    }
</style>
<div class="d-flex align-items-center justify-content-between card p-3 cookies-popup"
    style="position:fixed; bottom: 10px; z-index: 10000000000; flex-direction: row-reverse; gap: 5px">
    <div class="d-flex align-items-center justify-content-between" style=" gap: 5px">
        <span>We use third party cookies to personalize content, ads and analyze site traffic.</span>
        <img src="{{ asset('assets/img/cookies.png') }}" width="40">
    </div>
    <button class="btn btn-success accept-cookies">Okey</button>
</div>
<script>
    if (document.cookie.includes('blogtomeylaravel_session') == true || document.cookie.includes('cookie-popup') ==
        true) {
        document.querySelector('.cookies-popup').remove();
    }
    document.querySelector('.accept-cookies').addEventListener('click', () => {
        document.cookie = 'cookie-popup=1; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT';
        document.querySelector('.cookies-popup').remove();
    })
</script>
