<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LIFF - LINE Front-end Framework</title>
    <style>
        body {
            margin: 16px
        }

        button, img {
            display: none;
            width: 40%
        }

        button {
            padding: 16px
        }
    </style>
</head>
<body>
<div>
    <img id="pictureUrl">
    <p id="userID"></p>
    <p id="displayName"></p>
</div>

<button id="btnLogIn" onclick="logIn()">Log In With Line</button>
<button id="btnLogOut" onclick="logOut()">Log Out</button>
<script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
<script>
    function logOut() {
        liff.logout()
        window.location.reload()
    }

    function logIn() {
        liff.login({redirectUri: window.location.href})
    }

    async function getUserProfile() {
        const profile = await liff.getProfile()
        document.getElementById("pictureUrl").style.display = "block"
        document.getElementById("pictureUrl").src = profile.pictureUrl
        document.getElementById("userID").innerText = "userID : " + profile.userId
        document.getElementById("displayName").innerText = "user name : " + profile.displayName
    }

    async function main() {
        await liff.init({liffId: "1657565957-yz7Y7eBn"})
        if (liff.isInClient()) {
            getUserProfile()
        } else {
            if (liff.isLoggedIn()) {
                getUserProfile()
                document.getElementById("btnLogIn").style.display = "none"
                document.getElementById("btnLogOut").style.display = "block"
            } else {
                document.getElementById("btnLogIn").style.display = "block"
                document.getElementById("btnLogOut").style.display = "none"
            }
        }
    }

    main()
</script>
</body>
</html>
