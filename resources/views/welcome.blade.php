<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite('resources/css/app.css')
    <title>Home</title>
</head>

<body>
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5 ml-2">
                        <span class="sr-only">FinBuddy</span>
                        <img class="h-12 w-auto" src="img/FinBuddy Logo.png" alt="">
                    </a>
                </div>
                <div class="flex lg:flex-1 lg:justify-end">
                    <a href="login" class="text-sm/6 font-semibold text-gray-900">Log in <span
                            aria-hidden="true">&rarr;</span></a>
                </div>
            </nav>
        </header>

        <div class="relative isolate px-6 pt-1 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-30 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
            <div class="relative isolate overflow-hidden py-24 sm:py-32">
                <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
                    aria-hidden="true">
                </div>
                <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
                    aria-hidden="true">
                </div>
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:mx-0">
                        <h2 class="text-5xl font-semibold tracking-tight text-black sm:text-7xl">Atur Keuangan Lebih
                            Baik Bersama FinBuddy</h2>
                        <p class="mt-8 text-lg font-medium text-pretty text-black sm:text-xl/8">Solusi cerdas untuk
                            kelola pemasukan, pengeluaran, dan budgeting harianmu.</p>
                    </div>
                    <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
                        <dl class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="flex flex-col-reverse gap-1">
                                <dt class="text-base/7 text-black">Kelola Keuangan Pribadi</dt>
                                <dd class="text-4xl font-semibold tracking-tight text-black">Mudan & Cepat</dd>
                            </div>
                            <div class="flex flex-col-reverse gap-1">
                                <dt class="text-base/7 text-black">Rekapan Bulanan</dt>
                                <dd class="text-4xl font-semibold tracking-tight text-black">Otomatis</dd>
                            </div>
                            <div class="flex flex-col-reverse gap-1">
                                <dt class="text-base/7 text-black">Laporan Visual</dt>
                                <dd class="text-4xl font-semibold tracking-tight text-black">Interaktif</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="login"
                            class="rounded-md bg-[#3B577D] px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#4d71a3] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get
                            started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
