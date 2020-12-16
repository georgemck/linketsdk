<?php

/**
 * This should go in the functions.php of the Theme's child, otherwise in the functions.php of the WordPress Theme. 
 * Note this will be added to every page, but can be limited to specific pages if desired
 */


function wpb_hook_javascript()
{
?>
    <script type="text/javascript" nonce="abc123">
        var result;
        var networkState = "ETHERNET";
        var Connection = "EXCELLENT";

        var scheme = {};
        var fallbackToPWA = function(scheme) {
            window.location.href = scheme.pwa;
            // window.location.replace(scheme.pwa);
        };
        var openApp = function(scheme) {
            window.location.replace(scheme.app);
        };

        function triggerAppOpen(scheme) {
            openApp(scheme);
            setTimeout(fallbackToPWA(scheme), 750);
        }

        function submitButton(id) {
            var noInvalidChars = true;
            var tempLinket = {};
            var FoundLinket = 0;
            tempLinket.name = id.trim();
            if ((tempLinket.name.length > 0) && noInvalidChars) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        var nnn = xhr.responseText;
                        if (nnn == "[]") {
                            document.getElementById("linket_name").value = tempLinket.name;
                            result = "This linket was not found. <br /><br />Double check and try again.";
                            console.log(result);
                        } else {
                            try {
                                nnn = JSON.parse(nnn);
                                // console.log(nnn);
                            } catch (e) {
                                nnn = {};
                                nnn.linket = "Your password does not match this Linket";
                            }
                            if (nnn.linket == "not found") {
                                document.getElementById("connect").style.display = "block";
                                result = " LINKET <br /><br /><strong>[ ";
                                result += tempLinket.name + " ]</strong><br /><br />";
                                result += " NOT FOUND <br /><br />";
                            } else if (nnn.linket == "Your password does not match this Linket") {
                                document.getElementById("connect").style.display = "block";
                                result = nnn.linket + " <br /><br /><strong>[ ";
                                result += tempLinket.name + " ]</strong><br /><br />";
                                result += " <br /><br />";
                            } else {
                                try {
                                    result = "";
                                    scheme.pwa = nnn[0].value.appid;
                                    localStorage.setItem("lastAddress", nnn[0].value.ipaddress);
                                    if (nnn[0].value.appid.toString().search("tictactoe") !== -1) {
                                        scheme.app = "info.linket.mobile.tictactoe://screen";
                                    } else if (nnn[0].value.appid.toString().search("twoup") !==
                                        -1) {
                                        scheme.app = "info.linket.mobile.twoup://screentwoup";
                                    } else {
                                        scheme.app = "none";
                                    }
                                    console.log(scheme);
                                    triggerAppOpen(scheme);
                                } catch (e) {
                                    // console.log(e);
                                    result = "This Linket is not correct";
                                }
                            }
                        }
                    }
                };
                xhr.open('GET', linkerserver + '?command=getLinket&linket=' + tempLinket.name, true);
                if ((networkState != Connection.NONE) && (networkState != "")) {
                    xhr.send(null);
                } else {
                    alert("You are not Online.");
                }
            }
        }
        var linkerserver = "https://e18inyvxpe.execute-api.us-east-1.amazonaws.com/linket_backend";
        window.addEventListener('DOMContentLoaded', (event) => {
            google = {};
            const divs = document.querySelectorAll('.linketgroup');
            divs.forEach(el => el.addEventListener('click', event => {
                submitButton(event.target.innerText);
            }));
        });
    </script>
<?php
}
add_action('wp_head', 'wpb_hook_javascript');