<aside class="single_sidebar_widget newsletter_widget">
    <h4 class="widget_title">Newsletter</h4>

    <form action="{{ route('subscribe.store') }}" method="POST" onsubmit="subscribe(event)" id="subscibtionForm">
        <div class="form-group">
            <input type="email" name="email" class="form-control" onfocus="this.placeholder = ''"
                onblur="this.placeholder = 'Enter email'" placeholder='Enter email' required>
            <input type="hidden" id="user_ip" name="user_ip">
            <input type="hidden" id="user_country" name="user_country">
            <input type="hidden" id="user_city" name="user_city">
            <input type="hidden" id="user_region" name="user_region">
        </div>
        <button id="btn-submit" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
            type="submit">Subscribe</button>
    </form>
</aside>
