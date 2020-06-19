window.onload = function () {

    var element = $(".msg_card_body");
    element.scrollTop = element.scrollHeight;

    var user1 = "";
    var user2 = "";
    var image1 = "";
    var image2 = "";
    var name = "";

    $(".chat_user").mouseover(function () {
        $(this).css("cursor", "pointer");
        $(this).css("background-color", "rgba(0, 0, 0, 0.3)");
    })
    $(".chat_user").mouseleave(function () {
        $(this).css("background-color", "transparent");
    })

    //Jquery AJAX to dynamically fetch data from the DB
    $(".chat_user").click(function () {
        user1 = $(this).find('#user1').text().trim();
        user2 = $(this).find('#user2').text().trim();
        image1 = $(this).find('#image1').text().trim();
        image2 = $(this).find('#image2').text().trim();
        name = $(this).find('#name').text().trim();
        var previousMessageCount;
        var counter = 0;
        var messageCount;

        var interval = setInterval(function () {
                $.ajax({
                        url: '../XML/Chat.xml',
                        dataType: 'xml',
                        cache: false
                    })
                    .done(function (data) {
                        messageCount = 0;
                        // $(".msg_card_body").show();
                        $('.msg_card_body').html("");
                        $("#receiverId").html("<input type='hidden' name='receiverId' value='" + user2 + "'/>");
                        $("#header_image").html("<div id='image'><img src='" + image2 + "' class='rounded-circle user_img' id='headImage' width='30px' height='30px'> </div>");
                        $("#header_name").html(name);
                        $(data).find("conversation").each(function () {
                            if (this.getAttribute("user1") == user1 && this.getAttribute("user2") == user2 || this.getAttribute("user1") == user2 && this.getAttribute("user2") == user1) {
                                $('#messages .body').html("");
                                $(this).find("message").each(function () {
                                    messageCount++;
                                    if (this.getAttribute("user") == user2) {
                                        $('.msg_card_body').append("<div class='d-flex justify-content-start mb-4'><div class='img_cont_msg'><img src='" + image2 + "' class='rounded-circle user_img_msg'></div><div class='msg_container'>" + $(this).text() + "</div></div>");
                                    } else {
                                        $('.msg_card_body').append("<div class='d-flex justify-content-end mb-4'><div class='msg_container_send'>" + $(this).text() + "</div><div class='img_cont_msg'><img src='" + image1 + "' class='rounded-circle user_img_msg'></div></div>");
                                    }
                                })
                            }
                        })
                    })
                    .done(function (msg) {
                        if (counter == 0) {
                            $(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight);
                            counter++;
                        } else {
                            if (messageCount > previousMessageCount) {
                                $(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight);
                            }
                        }
                        previousMessageCount = messageCount;
                    })
                    .fail(function (xhr, status, error) {
                        // error handling
                    });
            },
            3000);
    });

    //Adding a new message
    $("#sendButton").click(function () {
        var message = $("#message").val();
        $.post('../Model/AJAXData.php', {
                message: message,
                user1: user1,
                user2: user2
            })
            .done(function (msg) {
                var message = $("#message").val("");
            })
            .fail(function (xhr, status, error) {
                // error handling
            });

    })
}


$('.msg_card_body').on('mousewheel DOMMouseScroll', function (e) {
    var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;

    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
    e.preventDefault();
});

function onSignIn(googleUser) {
    //After Signing in, AJAX jQeury request is sent to the
    var profile = googleUser.getBasicProfile();
    var auth2 = gapi.auth2.getAuthInstance();
    googleUser.disconnect()
    $.post('../Model/AJAXData.php', {
            id: profile.getId(),
            firstName: profile.getGivenName(),
            lastName: profile.getFamilyName(),
            url: profile.getImageUrl(),
            email: profile.getEmail()
        })
        .done(function (msg) {
            window.location = "../View/ChatList.php";
        })
        .fail(function (xhr, status, error) {
            // error handling
        });
}

function signOut() {
    $.post('../Model/AJAXData.php', {
            signOut: true,
        })
        .done(function (msg) {})
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {});

}

function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
}