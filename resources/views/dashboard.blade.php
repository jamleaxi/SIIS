<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 text-black dark:text-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="col-12" style="margin: 30px" align="justify">
                    <img src="{{ asset('img/siis-logo.png') }}" width="200px">
                    <hr class="mt-3">
                    <h1 class="mt-3" style="font-size: 16px;">
                        Hi <b style="color: goldenrod">{{ Auth::user()->name }}</b>, {{ Auth::user()->position_full }} of the {{ Auth::user()->office_full }}
                    </h1>

                    <h1 style="font-size: 18px;">
                        <b style="color: blue" style="font-size: 18px;">Welcome to the JRMSU's Supply Inventory Information System (SIIS)!</b>
                    </h1>
                    <hr class="mt-3">

                    <p class="mt-3">
                        At the heart of the JRMSU MIS Unit's objectives lies the mission to enhance efficiency in academic and administrative operations through the deployment of cutting-edge information systems. In pursuit of this goal and with the arising challenges in supply management, the MIS unit has developed an innovative solution titled the <i>Supply Inventory Information System (SIIS)</i> to revolutionize the processes within the Supply Unit.
                    </p>
                    <hr class="mt-3">

                    <p class="mt-3">
                        <b>SUPPLY INVENTORY INFORMATION SYSTEM (SIIS)</b><br/>
                        <b>Information System Manual</b><br/>
                        <br/>
                        <u>I.	ACCOUNT REGISTRATION</u><br/>
                        1.	Open any web browser and type in the address bar: siis.jrmsu.edu.ph<br/>
                        2.	On the home page, click “SIGN ME UP”<br/>
                        3.	Fill out the necessary information in the form<br/>
                        4.	Click the “REGISTER” button<br/>
                        5.	Upon successful submission, your account will still be on hold for administrator approval<br/>
                        6.	You can try logging in back to SIIS to check if your account has been activated<br/>
                        <br/>
                        <u>II.	LOGGING IN</u><br/>
                        1.	Open any web browser and type in the address bar: siis.jrmsu.edu.ph<br/>
                        2.	On the home page, click “SIGN ME IN”<br/>
                        3.	On the login page, type in your JRMSU institutional email address and your password<br/>
                        4.	Click the “LOG IN” button<br/>
                        5.	If your account is active and your credentials are correct, you will be redirected to the SIIS dashboard.<br/>
                        6.	If your account is not yet activated by the administrator, you will be redirected to the locked account page.<br/>
                        7.	If your account is deactivated, you will be directed to the suspended account page.<br/>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
