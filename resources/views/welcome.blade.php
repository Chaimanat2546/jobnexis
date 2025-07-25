<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JobNexis</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2412bed399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body class="font-sans">
    <button id="backToTopBtn"
        class="btn btn-circle fixed right-20 bottom-20 z-49 bg-gray-200 hover:bg-gray-300 hover:scale-105 transition-transform duration-200 shadow-lg btn-xl"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
        <i class="fa-solid fa-up-long"></i>
    </button>

    <div class="bg-transparent navbar fixed top-0 left-0 z-50" >
        <div class="navbar-start"></div>
        <div class="hidden navbar-center lg:flex gap-20 rounded-3xl px-6" id="navbar">
            <a href="/">
                <div class=" hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset('image\web-image\logo.png') }}" alt="logo" class="w-full h-14">
                </div>
            </a>
            <ul class="px-1 text-lg font-bold menu menu-horizontal ">
                <li class="hover:scale-105 transition-transform duration-200"><a>เรียนรู้ทักษะ</a></li>
                <li class="hover:scale-105 transition-transform duration-200"><a>หางาน</a></li>
                <li class="hover:scale-105 transition-transform duration-200"><a>ผู้ประกอบการ</a></li>
                <li class="hover:scale-105 transition-transform duration-200"><a>ติดต่อเรา</a></li>
            </ul>
            <div class="hover:scale-105 transition-transform duration-200">
                <a class="text-lg font-bold bg-blue-600 rounded-xl btn text-base-100 ">เข้าสู่ระบบ</a>
            </div>
        </div>
        <div class="navbar-end"></div>
    </div>
    <div class=" text-base-content">
        <div
            class="bg-[linear-gradient(to_bottom,_theme('colors.sky.100')_20%,_theme('colors.blue.300')_100%)] p-28 pb-0 flex flex-row justify-between items-center gap-4 text-base-content">
            <div>
                <div class="text-base-content flex flex-col items-start justify-start gap-14">
                    <h1 class="text-6xl font-bold">
                        "หางานง่าย<br>
                        เรียนรู้ทักษะรอบด้าน<br>
                        เข้าถึงคนที่ใช่<br>
                        ตามที่คุณต้องการ"</h1>
                    <h4 class=" text-xl">สมัครสมาชิก เพื่อเริ่มต้นใช้งานระบบของเราได้ทันที</h4>
                </div>

                <div class="flex flex-col items-start gap-4 mt-6">
                    <button class="btn btn-lg bg-blue-600 text-base-100">
                        หางาน/เรียนรู้ทักษะ
                        <i class="fa-solid fa-circle-arrow-right"></i>
                    </button>
                    <button
                        class="btn bg-transparent border-1 border-blue-600 hover:bg-blue-600 hover:text-base-100 text-blue-600">
                        ผู้ประกอบการ
                        <i class="fa-solid fa-building"></i>
                    </button>
                    <button
                        class="btn bg-transparent border-1 border-blue-600 hover:bg-blue-600 hover:text-base-100 text-blue-600">
                        สถานศึกษา
                        <i class="fa-solid fa-school"></i>
                    </button>
                </div>
            </div>
            <div>
                <img src="{{ asset('image\web-image\smiling-woman.png') }}" alt="women smiling"
                    class="object-cover m-0 p-0 block w-full h-[600px]">
            </div>
        </div>
        <div class="px-28 py-20 flex flex-col gap-10 ">
            <div class=" flex flex-col items-start justify-start gap-4">
                <h2 class=" text-4xl font-bold">พร้อมที่จะจินตนาการอาชีพของคุณใหม่หรือยัง?</h2>
                <p class=" text-xl">รับทักษะและประสบการณ์ในโลกแห่งความเป็นจริงที่นายจ้างต้องการด้วย Career Accelerators
                </p>
            </div>
            <div class="flex flex-row justify-between items-center">
                <div class="card card-sm bg-base-100 w-96 shadow-xl/30">
                    <figure class="px-5 pt-5">
                        <img src="{{ asset('image\web-image\ai-robot.jpg') }}"
                            class="rounded-xl h-40 w-full object-cover" alt="ai-web" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">
                            AI Developer
                        </h2>
                        <div class="card-actions justify-start">
                            <div class="badge badge-outline"><i class="fa-solid fa-star" style="color: #ffc800;"></i>4.6
                            </div>
                            <div class="badge badge-outline">450K rating</div>
                        </div>
                    </div>
                </div>
                <div class="card card-sm bg-base-100 w-96 shadow-xl/30">
                    <figure class="px-5 pt-5">
                        <img src="{{ asset('image\web-image\working-html.jpg') }}"
                            class="rounded-xl h-40 w-full object-cover" alt="working-html" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">
                            Full Stack Developer
                        </h2>
                        <div class="card-actions justify-start">
                            <div class="badge badge-outline"><i class="fa-solid fa-star" style="color: #ffc800;"></i>4.7
                            </div>
                            <div class="badge badge-outline">300K rating</div>
                        </div>
                    </div>
                </div>
                <div class="card card-sm bg-base-100 w-96 shadow-xl/30">
                    <figure class="px-5 pt-5">
                        <img src="{{ asset('image\web-image\work-group.jpg') }}"
                            class="rounded-xl h-40 w-full object-cover" alt="work-group" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">
                            Project Management
                        </h2>
                        <div class="card-actions justify-start">
                            <div class="badge badge-outline"><i class="fa-solid fa-star" style="color: #ffc800;"></i>4.4
                            </div>
                            <div class="badge badge-outline">250K rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-28 py-10 flex justify-between items-center bg-indigo-50 ">
            <div class="relative w-[45%] h-[300px]">

                <!-- รูป 1 (บนซ้าย) -->
                <img src="{{ asset('image\web-image\formal-wear.jpg') }}"
                    class="absolute top-0 left-20 w-64 h-48 object-cover rounded-xl shadow-md" alt="Formal wear">

                <!-- รูป 2 (ขวาบน) -->
                <img src="{{ asset('image\web-image\group-asia.jpg') }}"
                    class="absolute top-25 right-25 w-40 h-36 object-cover rounded-xl shadow-md" alt="Group asia">

                <!-- รูป 3 (ล่างซ้าย) -->
                <img src="{{ asset('image\web-image\handshake-up.jpg') }}"
                    class="absolute bottom-0 left-45 h-24 w-36 object-cover rounded-xl shadow-md" alt="Handshake">

            </div>
            <div class="w-[55%] flex flex-col items-start justify-center gap-2">
                <h2 class=" text-4xl font-bold">เริ่มต้นเส้นทางที่นำไปสู่โอกาสงานที่ดีกว่า</h2>
                <p class=" text-base">เข้าร่วมกับผู้คนหลายพันที่เปลี่ยนชีวิตด้วย <b>ทักษะใหม่ สร้างโอกาส งานที่ดีกว่า
                        เพิ่มรายได้ และก้าวสู่อาชีพในฝัน</b></p>
                <button class="btn bg-blue-600 text-base-100 mt-3">
                    เข้าร่วมกับเรา
                    <i class="fa-solid fa-circle-arrow-right"></i>
                </button>
            </div>
        </div>
        <div class=" px-44 py-10">
            <div class="flex flex-col items-center justify-center gap-4 mb-8">
                <h1 class=" text-6xl font-bold">ทำไมต้อง JobNexis</h1>
                <p class=" text-base">เราให้มากกว่าการหางาน เราช่วยให้คุณเติบโตและพัฒนาตัวเองไปพร้อมกับอาชีพที่คุณรัก
                </p>
            </div>
            <div class="flex flex-row justify-evenly items-center">
                <div class="card bg-base-100 w-72 shadow-sm rounded-3xl">
                    <figure class="px-10 pt-10">
                        <div class="bg-blue-600 rounded-full w-20 h-20 flex items-center justify-center">
                            <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">งานคุณภาพ</h2>
                        <p>
                            ค้นหางานจากบริษัทชั้นนำ<br>ที่ผ่านการคัดกรองมาแล้วอย่างดี<br>เพื่อให้คุณได้โอกาสที่ดีที่สุด
                        </p>
                    </div>
                </div>
                <div class="card bg-base-100 w-72 shadow-sm rounded-3xl">
                    <figure class="px-10 pt-10">
                        <div class="bg-blue-600 rounded-full w-20 h-20 flex items-center justify-center">
                            <i class="fa-solid fa-book-open" style="color: #ffffff;"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">ฝึกสกิลออนไลน์</h2>
                        <p>
                            เรียนรู้ทักษะใหม่ๆ ที่ตลาดต้องการ<br>ผ่านคอร์สเรียนคุณภาพสูง<br>จากผู้เชี่ยวชาญในแต่ละสาขา
                        </p>
                    </div>
                </div>
                <div class="card bg-base-100 w-72 shadow-sm rounded-3xl">
                    <figure class="px-10 pt-10">
                        <div class="bg-blue-600 rounded-full w-20 h-20 flex items-center justify-center">
                            <i class="fa-solid fa-chart-simple" style="color: #ffffff;"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">วิเคราะห์อาชีพ</h2>
                        <p>
                            รับคำแนะนำเส้นทางอาชีพที่เหมาะกับคุณ<br>ด้วยระบบ AI<br>ที่วิเคราะห์จากข้อมูลและทักษะของคุณ
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-28 py-10 flex justify-around items-center bg-gray-100 border-t-1 border-gray-200">
            <div>
                <div>
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <a href="https://maps.app.goo.gl/3zQypKQbXfpekfZTA" target="_blank">
                    <p>คณะวิทยาการสารสนเทศ มหาวิทยาลัยบูรพา<br>169 ถ.ลงหาดบางแสน ต.แสนสุข<br>อ.เมือง จ.ชลบุรี 20131
                        ประเทศไทย</p>
                </a>
                <p class=" text-gray-500">LOCATION</p>
            </div>
            <div>
                <div>
                    <i class="fa-solid fa-phone"></i>
                </div>
                <p>EMAIL : esp@informatics.buu.ac.th</p>
                <p>Phone : 085-818-8910</p>
                <p class=" text-gray-500">CONTACT</p>
            </div>
            <div>
                <div>
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <a href="https://www.facebook.com/profile.php/?id=61556923694978" target="_blank"><i
                        class="fab fa-facebook"></i> Eastern Software Park at BUU</a><br>
                <a href="https://esp.informatics.buu.ac.th" target="_blank"><i class="fa-solid fa-earth-europe"
                        target="_blank"></i> https://esp.informatics.buu.ac.th<a>
                        <p class=" text-gray-500">SOCIAL MEDIA</p>
            </div>
        </div>
    </div>
    </div>
</body>
<footer>
    <div class="bg-gray-100 text-center p-4">
        <p class="text-gray-400">© 2025 JobNexis. All rights reserved.</p>
        <p class="text-gray-400">Developed by Eastern Software Park at BUU</p>
    </div>
</footer>
<script>
    const btn = document.getElementById("backToTopBtn");
    const navbar = document.getElementById("navbar");
    window.addEventListener("scroll", () => {
        const scrollY = window.scrollY;

        if (scrollY > 100) {
            btn.classList.remove("hidden");
            // เปลี่ยนสีตาม scroll
            if (scrollY > 300) {
                navbar.classList.remove("bg-transparent");
                navbar.classList.add("bg-[linear-gradient(to_bottom,_theme('colors.sky.100')_20%,_theme('colors.sky.200')_100%)]"); // สีใหม่ตอนเลื่อนเยอะ
            } else {
                navbar.classList.remove("bg-[linear-gradient(to_bottom,_theme('colors.sky.100')_20%,_theme('colors.sky.200')_100%)]");
                navbar.classList.add("bg-transparent"); // สีเริ่มต้น
            }
        } else {
            btn.classList.add("hidden");
        }
    });
</script>

</html>
