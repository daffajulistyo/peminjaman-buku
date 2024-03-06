<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FAQ - SIPON</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_pasaman.png') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #2a9d8f;
            font-family: 'Muli', sans-serif;
        }

        h1 {
            margin: 50px 0 30px;
            text-align: center;
            color: #fff;
        }

        .faqs-container {
            margin: 0 auto;
            max-width: 800px;
        }

        .faq {
            background-color: transparent;
            border: 1px solid #fff;
            border-radius: 10px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            margin: 20px 0;
            transition: 0.3s ease;
        }

        .faq.active {
            background-color: #287271;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .faq.active::before {
            color: #3498db;
            top: -10px;
            left: -30px;
            transform: rotateY(180deg);
        }

        .faq-title {
            margin: 0 35px 0 0;
            color: #fff;

        }

        .faq-text {
            display: none;
            margin: 30px 0 0;
            color: #fff;
        }

        .faq.active .faq-text {
            display: block;
        }

        .faq-toggle {
            background-color: transparent;
            border: none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            padding: 0;
            position: absolute;
            top: 20px;
            right: 30px;
            height: 30px;
            width: 30px;
        }

        .faq-toggle:focus {
            outline: none;
        }

        .faq.active .faq-toggle {
            background-color: #287271;
        }

        .faq-toggle .fa-times {
            display: none;
        }

        .faq.active .faq-toggle .fa-times {
            display: block;
        }

        .faq-toggle .fa-chevron-down {
            color: #fff;
        }

        .faq.active .faq-toggle .fa-chevron-down {
            display: none;
        }

        /* SOCIAL PANEL CSS */
        .social-panel-container {
            position: fixed;
            right: 0;
            bottom: 80px;
            transform: translateX(100%);
            transition: transform 0.4s ease-in-out;
        }

        .social-panel-container.visible {
            transform: translateX(-10px);
        }

        .social-panel {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 16px 31px -17px rgba(0, 31, 97, 0.6);
            border: 5px solid #001F61;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Muli';
            position: relative;
            height: 169px;
            width: 370px;
            max-width: calc(100% - 10px);
        }

        .social-panel button.close-btn {
            border: 0;
            color: #97A5CE;
            cursor: pointer;
            font-size: 20px;
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .social-panel button.close-btn:focus {
            outline: none;
        }

        .social-panel p {
            background-color: #001F61;
            border-radius: 0 0 10px 10px;
            color: #fff;
            font-size: 14px;
            line-height: 18px;
            padding: 2px 17px 6px;
            position: absolute;
            top: 0;
            left: 50%;
            margin: 0;
            transform: translateX(-50%);
            text-align: center;
            width: 235px;
        }

        .social-panel p i {
            margin: 0 5px;
        }

        .social-panel p a {
            color: #FF7500;
            text-decoration: none;
        }

        .social-panel h4 {
            margin: 20px 0;
            color: #97A5CE;
            font-family: 'Muli';
            font-size: 14px;
            line-height: 18px;
            text-transform: uppercase;
        }

        .social-panel ul {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .social-panel ul li {
            margin: 0 10px;
        }

        .social-panel ul li a {
            border: 1px solid #DCE1F2;
            border-radius: 50%;
            color: #001F61;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            width: 50px;
            text-decoration: none;
        }

        .social-panel ul li a:hover {
            border-color: #FF6A00;
            box-shadow: 0 9px 12px -9px #FF6A00;
        }

        .floating-btn {
            border-radius: 26.5px;
            background-color: #001F61;
            border: 1px solid #001F61;
            box-shadow: 0 16px 22px -17px #03153B;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            line-height: 20px;
            padding: 12px 20px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .floating-btn:hover {
            background-color: #ffffff;
            color: #001F61;
        }

        .floating-btn:focus {
            outline: none;
        }

        .floating-text {
            background-color: #001F61;
            border-radius: 10px 10px 0 0;
            color: #fff;
            font-family: 'Muli';
            padding: 7px 15px;
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 998;
        }

        .floating-text a {
            color: #FF7500;
            text-decoration: none;
        }

        .faq-text p {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #fff;
            margin-bottom: 10px;
            text-align: justify;
        }


        @media screen and (max-width: 480px) {

            .social-panel-container.visible {
                transform: translateX(0px);
            }

            .floating-btn {
                right: 10px;
            }
        }
    </style>

</head>

<body>
    <h1>Frequently Asked Questions</h1>
    @foreach ($faqs as $faq)
        <div class="faqs-container">
            <div class="faq">
                <h3 class="faq-title">
                    {{ $faq->question }}
                </h3>
                <div class="faq-content">
                    <div class="faq-text">
                        @if ($faq->question_image)
                            <div class="faq-content">
                                <div class="faq-image">
                                    <img src="{{ asset('apps/public/images/' . $faq->question_image) }}" alt="Gambar Pertanyaan"
                                        style="max-width: 50%;">
                                </div>
                            </div>
                            @endif
                            <p>{{ $faq->answer }}</p>

                        @if ($faq->answer_image)
                            <div class="faq-content">
                                <div class="faq-image">
                                    <img src="{{ asset('apps/public/images/' . $faq->answer_image) }}" alt="Gambar Jawaban"
                                        style="max-width: 50%;">
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                <button class="faq-toggle">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endforeach


</body>
<script>
    const toggles = document.querySelectorAll('.faq-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            toggle.parentNode.classList.toggle('active');
        });
    });
</script>

</html>
