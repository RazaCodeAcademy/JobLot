<footer class="footer">
    <div class="container">
        <div class="footer-wrapper">
            <div class="footer-left">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('/public/frontend/img/logo-grey.png') }}" alt="logo-grey" />
                </a>
                <ul class="footer-navigation">
                    <li><a href="{{ route('about_us') }}">About</a></li>
                    <li><a href="{{ route('contact_us') }}">Contact us</a></li>
                    <li><a href="{{ route('site_map') }}">Site map</a></li>
                    <li><a href="{{ route('career') }}">Career</a></li>
                </ul>
            </div>
            <div class="footer-right">
                <ul class="footer-social">
                    <li>
                      
                        <a href="https://facebook.com/" href="javascript:void(0)" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/" href="javascript:void(0)" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://google.com/" href="javascript:void(0)" target="_blank">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                </ul>
                <p>All rights reserved <script>document.write(new Date().getFullYear())</script></p>
            </div>
        </div>
    </div>
</footer>