@extends ('layouts.default_body')
@section('content')

<div class="default_container_margin container primary_background_color default_padding default_margin default_radius under_shadow">
        <br>
        <h2>{{translate("Frequently Asked Questions (FAQ)")}}</h2>
        <br>
        <div class="faq-item">
            <h3>{{translate("What types of computer parts do you offer?")}}</h3>
            <p>{{translate("We offer a wide range of computer parts, including processors, GPUs, motherboards, RAM, storage devices, and peripherals.")}}</p>
        </div>
        <div class="faq-item">
            <h3>{{translate("Do you provide shipping?")}}</h3>
            <p>{{translate("Yes, we offer fast shipping on all orders to ensure you receive your parts as quickly as possible.")}}</p>
        </div>
        <div class="faq-item">
            <h3>{{translate("Are your prices competitive?")}}</h3>
            <p>{{translate("Absolutely! We strive to offer competitive prices on all our products without compromising quality.")}}</p>
        </div>
        <div class="faq-item">
            <h3>{{translate("Can I get support if I have questions about my order?")}}</h3>
            <p>{{translate("Yes! Our expert customer support team is here to assist you with any questions or concerns you may have.")}}</p>
        </div>
        <div class="faq-item">
            <h3>{{translate("Do you have a return policy?")}}</h3>
            <p>{{translate("Yes, we have a return policy in place. Please refer to our Returns page for detailed information.")}}</p>
        </div>
        <div class="faq-item">
            <h3>{{translate("How do you handle my privacy?")}}</h3>
            <p>{{translate("We take your privacy seriously. Please refer to our")}} <a href="/privacy-policy">{{translate("Privacy Policy")}}</a> {{translate("for information on how we collect, use, and protect your personal data.")}}</p>
        </div>

</div>

@endsection