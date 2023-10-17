// following creates the relationship between footerer, main and aaside.
let aside = document.querySelector('body aside');
let main = document.querySelector('body main');
let footer = document.querySelector('body footer');
let header= document.querySelector('body header');

//following snippet scrolls nav links to present page
function scrollToElement(active_element) {
    function scrollE(time, parent) {
        if ((parent.getBoundingClientRect().top < active_element.getBoundingClientRect().top - 8) && (parent.scrollTop < parent.scrollHeight - parent.clientHeight - 3)) {
            parent.scrollTop += 8;
            parent.scrollTop = parent.scrollTop >= active_element.offsetTop ? active_element.offsetTop : parent.scrollTop;
            id = requestAnimationFrame(function (e) {scrollE(e, parent)});
        } else {
            cancelAnimationFrame(id);
        }
    }
    let id = requestAnimationFrame(function (e) {scrollE(e, document.querySelector('aside nav'))});   
}
Array.from(document.querySelectorAll('aside nav li')).find(e => {
    if (e.getAttribute('data-active') == 'yes') {
        setTimeout(function () {scrollToElement(e);}, 300);
    }
})

//following snippet toggles sidebar on/off
document.getElementById('sidebar_control').addEventListener('click', function (e) {
    let sidebar = document.querySelector('aside.sidebar');
    let left = sidebar.style.left.slice(0, sidebar.style.left.length - 1);
    if (left < 0 || !left) {
        sidebar.style.transition = '.4s';
        sidebar.style.left = '0';
        setTimeout(() => sidebar.style.transition = '0s', 10);
    } else {
        sidebar.style.transition = '.5s';
        sidebar.style.left = '-90%';
        setTimeout(() => sidebar.style.transition = '0s', 10); 
    }
})


//following snippet confirms logout
let logoutExceptedPages = ['/fpc/school/index.php', '/fpc/school_blog/index.php', '/fpc/school_blog/publish_post.php', '/fpc/school_blog/article.php', '/fpc/school/about_school.php', '/fpc/school/contact_info.php', '/fpc/school/developers_contact.php', '/fpc/results_archive/index.php'];
if (!logoutExceptedPages.includes(document.location.pathname)) { 
    document.getElementById('logout_icon').addEventListener('click', function show_notification (e) {
        e.preventDefault();
        if (!show_notification.shown) {
            let parent = document.createElement('section');
            parent.id = 'notification_sec';
            let confirmBox = document.createElement('article');
            confirmBox.id = 'confirm_logout';
            let text = document.createElement('p');
            text.innerHTML = 'Are you sure you want to logout?';
            let form = document.createElement('form');
            form.action = './logout.php';
            let type = document.querySelector('input#mail_type[type=hidden]');
            if (type) {
                form.action = '../'+type.value+'/logout.php';
            }
            console.log(type);
            console.log(document.location.pathname);
            if (document.location.pathname == '/fpc/school_blog/write_blog.php') {
                if (type.value == 'staff' || type.value == 'student') {
                    form.action = './index.php';
                }
            }
            let stay = document.createElement('button');
            stay.id = 'stay';
            stay.textContent = 'Stay';
            stay.onclick = function (e) {
                document.getElementById('notification_sec').remove();
                show_notification.shown = false;
            }
            let leave = document.createElement('button');
            leave.id = 'leave';
            leave.textContent = 'Log out';
            leave.onclick = function (e) {
                form.submit();
            }
            form.appendChild(stay);
            form.appendChild(leave);
            confirmBox.appendChild(text);
            confirmBox.appendChild(form);
            parent.appendChild(confirmBox);
            document.body.appendChild(parent);
            show_notification.shown = true;
        }
    })
}