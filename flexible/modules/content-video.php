<!-- c--layout-d--second si el bg es claro --> 

<section class="c--layout-d f--background-c">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12">
                <div class="c--layout-d__hd">
                    <p class="c--layout-d__hd__title">WE ARE SEI</p>
                    <p class="c--layout-d__hd__subtitle">SEI is a management consulting firm delivering fresh perspectives and reliable results.</p>
                </div>
            </div>
             <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12">
           <!-- este si es embed
                 <button
                    type="button"
                    class="c--layout-d__wrapper"
                    data-modal-open="my-modal"
                    data-modal-video-type="file"
                    data-modal-video-url="https://placeholder.terrahq.com/1-min-video.mp4"
                >
                   <img class="c--layout-d__wrapper__media" src="http://placeholder.terrahq.com/img-1by1.webp" alt="">
                    <svg class="c--layout-d__wrapper__artwork" xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                        <rect width="56" height="56" rx="28" fill="#FFFFF8"/>
                        <path d="M18.6641 11.9941V44.6608L44.3307 28.3275L18.6641 11.9941Z" fill="#F01840"/>
                    </svg>
                </button> -->

                 <button
                    type="button"
                    class="c--layout-d__wrapper"
                    data-modal-open="my-modal"
                    data-modal-video-type="embed"
                    data-modal-video-url="https://www.youtube.com/embed/ScMzIvxBSi4?si=6xVCmtGs3Wz9FBFm"
                >
                   <img class="c--layout-d__wrapper__media" src="http://placeholder.terrahq.com/img-1by1.webp" alt="">
                    <svg class="c--layout-d__wrapper__artwork" xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                        <rect width="56" height="56" rx="28" fill="#FFFFF8"/>
                        <path d="M18.6641 11.9941V44.6608L44.3307 28.3275L18.6641 11.9941Z" fill="#F01840"/>
                    </svg>
                </button>
             
            </div>
            <div class="f--col-4 f--col-tabletm-12 u--display-flex u--align-items-flex-end">
                 <div class="c--layout-d__ft">
                    <p class="c--layout-d__ft__content">There’s always a better way to do business — and we have 30 years of evidence to prove it. We help some of the world’s most recognizable brands solve problems, create opportunity, and achieve more than they could alone.</p>
                    <a class="c--layout-d__ft__btn g--btn-01">About us</a>
                </div>
            </div>
        </div>
    </div>
              <?php include(locate_template('components/modal/modal-a.php', false, false)); ?>
</section>