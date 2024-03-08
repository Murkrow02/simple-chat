//Generate two letters initials from a name
function getInitials(name) {
    const words = name.trim().split(' ');
    let initials = '';

    for (let i = 0; i < words.length && initials.length < 2; i++) {
        initials += words[i][0].toUpperCase();
    }

    return initials;
}

// Function to replace HTML entities with their corresponding characters
function decodeHtmlEntities(input) {
    const textarea = document.createElement('textarea');
    textarea.innerHTML = input;
    return textarea.value;
}

function setChatHeaderTitle(title){
    title = decodeHtmlEntities(title);
    document.getElementById('chat-header-title').innerText = title;
}

// Applies the avatar function and the proper action to given class cell
// Not using id as it could happen that the same person is in two categories at the same time (and so two elements will have same id)
function applyAvatarToCell(userId)
{
    //If in page there is an element with class chat-cell, then cycle through each element
    document.querySelectorAll(`[data-chat-id="${userId}"]`).forEach((cell) => {

        //Get data-id from cell
        let id = cell.getAttribute('data-chat-id');

        //Set cell avatar for each element with class avatar-<id> (need to use class instead of id because same id could be used in multiple cells)
        document.querySelectorAll('.avatar-' + id).forEach((avatar) => {
            new Avatar(avatar, {
                'useGravatar': false,
                'initials': getInitials(document.querySelector('.chat-title-' + id).innerText),
            });
        });

        // //Add on-click to open chat
        // let openNewChat = cell.getAttribute('data-chat-new') === 'true';
        // cell.addEventListener('click', () => {
        //     let url = openNewChat ? "chat/new" : "chat";
        //     window.location.href = `/${url}/${id}${window.location.search}`;
        // });

    });
}




// Avatar
var Avatar=function(){"use strict";function t(t,e){return t+e&4294967295}function e(e,i,a,r,s,n){return i=t(t(i,e),t(r,n)),t(i<<s|i>>>32-s,a)}function i(t,i,a,r,s,n,l){return e(i&a|~i&r,t,i,s,n,l)}function a(t,i,a,r,s,n,l){return e(i&r|a&~r,t,i,s,n,l)}function r(t,i,a,r,s,n,l){return e(i^a^r,t,i,s,n,l)}function s(t,i,a,r,s,n,l){return e(a^(i|~r),t,i,s,n,l)}function n(e,n){let l=e[0],o=e[1],c=e[2],h=e[3];l=i(l,o,c,h,n[0],7,-680876936),h=i(h,l,o,c,n[1],12,-389564586),c=i(c,h,l,o,n[2],17,606105819),o=i(o,c,h,l,n[3],22,-1044525330),l=i(l,o,c,h,n[4],7,-176418897),h=i(h,l,o,c,n[5],12,1200080426),c=i(c,h,l,o,n[6],17,-1473231341),o=i(o,c,h,l,n[7],22,-45705983),l=i(l,o,c,h,n[8],7,1770035416),h=i(h,l,o,c,n[9],12,-1958414417),c=i(c,h,l,o,n[10],17,-42063),o=i(o,c,h,l,n[11],22,-1990404162),l=i(l,o,c,h,n[12],7,1804603682),h=i(h,l,o,c,n[13],12,-40341101),c=i(c,h,l,o,n[14],17,-1502002290),o=i(o,c,h,l,n[15],22,1236535329),l=a(l,o,c,h,n[1],5,-165796510),h=a(h,l,o,c,n[6],9,-1069501632),c=a(c,h,l,o,n[11],14,643717713),o=a(o,c,h,l,n[0],20,-373897302),l=a(l,o,c,h,n[5],5,-701558691),h=a(h,l,o,c,n[10],9,38016083),c=a(c,h,l,o,n[15],14,-660478335),o=a(o,c,h,l,n[4],20,-405537848),l=a(l,o,c,h,n[9],5,568446438),h=a(h,l,o,c,n[14],9,-1019803690),c=a(c,h,l,o,n[3],14,-187363961),o=a(o,c,h,l,n[8],20,1163531501),l=a(l,o,c,h,n[13],5,-1444681467),h=a(h,l,o,c,n[2],9,-51403784),c=a(c,h,l,o,n[7],14,1735328473),o=a(o,c,h,l,n[12],20,-1926607734),l=r(l,o,c,h,n[5],4,-378558),h=r(h,l,o,c,n[8],11,-2022574463),c=r(c,h,l,o,n[11],16,1839030562),o=r(o,c,h,l,n[14],23,-35309556),l=r(l,o,c,h,n[1],4,-1530992060),h=r(h,l,o,c,n[4],11,1272893353),c=r(c,h,l,o,n[7],16,-155497632),o=r(o,c,h,l,n[10],23,-1094730640),l=r(l,o,c,h,n[13],4,681279174),h=r(h,l,o,c,n[0],11,-358537222),c=r(c,h,l,o,n[3],16,-722521979),o=r(o,c,h,l,n[6],23,76029189),l=r(l,o,c,h,n[9],4,-640364487),h=r(h,l,o,c,n[12],11,-421815835),c=r(c,h,l,o,n[15],16,530742520),o=r(o,c,h,l,n[2],23,-995338651),l=s(l,o,c,h,n[0],6,-198630844),h=s(h,l,o,c,n[7],10,1126891415),c=s(c,h,l,o,n[14],15,-1416354905),o=s(o,c,h,l,n[5],21,-57434055),l=s(l,o,c,h,n[12],6,1700485571),h=s(h,l,o,c,n[3],10,-1894986606),c=s(c,h,l,o,n[10],15,-1051523),o=s(o,c,h,l,n[1],21,-2054922799),l=s(l,o,c,h,n[8],6,1873313359),h=s(h,l,o,c,n[15],10,-30611744),c=s(c,h,l,o,n[6],15,-1560198380),o=s(o,c,h,l,n[13],21,1309151649),l=s(l,o,c,h,n[4],6,-145523070),h=s(h,l,o,c,n[11],10,-1120210379),c=s(c,h,l,o,n[2],15,718787259),o=s(o,c,h,l,n[9],21,-343485551),e[0]=t(l,e[0]),e[1]=t(o,e[1]),e[2]=t(c,e[2]),e[3]=t(h,e[3])}function l(t){const e=[];for(let i=0;i<64;i+=4)e[i>>2]=t.charCodeAt(i)+(t.charCodeAt(i+1)<<8)+(t.charCodeAt(i+2)<<16)+(t.charCodeAt(i+3)<<24);return e}const o="0123456789abcdef".split("");function c(t){let e="",i=0;for(;i<4;i++)e+=o[t>>8*i+4&15]+o[t>>8*i&15];return e}const h=t=>function(t){for(let e=0;e<t.length;e++)t[e]=c(t[e]);return t.join("")}(function(t){const e=t.length,i=[1732584193,-271733879,-1732584194,271733878];let a;for(a=64;a<=t.length;a+=64)n(i,l(t.slice(a-64,a)));t=t.slice(Math.max(0,a-64));const r=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];for(a=0;a<t.length;a++)r[a>>2]|=t.charCodeAt(a)<<(a%4<<3);if(r[a>>2]|=128<<(a%4<<3),a>55)for(n(i,r),a=0;a<16;a++)r[a]=0;return r[14]=8*e,n(i,r),i}(t));class g{constructor(t){let e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if(!t)throw new Error("No image element provided.");this.element=t,this.settings={size:80,fallbackImage:"data:image/svg+xml,%3Csvg width='60' xmlns='http://www.w3.org/2000/svg' height='60' viewBox='0 0 60 60'%3E%3Cpath fill='%23bcc7ce' d='M0 0h60v60h-60z'/%3E%3Cg fill-rule='evenodd'%3E%3Cpath fill='%23a4b1b9' d='M30.1 54.8c-6.7 0-13.1-2.8-17.6-7.7l-.5-.5v-2.6h.2c.4-4 1.6-6.7 3.4-7.6 1.3-.6 2.9-1.1 4.9-1.6v-1l1-.3s.7-.2 1.7-.5c0-.5-.1-.7-.1-.9-.6-1-1.5-3.3-2.1-6l-1.7-1.4.2-.9s.2-.9 0-1.9c-.2-.9.1-1.5.3-1.8.3-.3.6-.5 1-.6.3-1.6.9-3.1 1.7-4.3-1.3-1.5-1.7-2.6-1.5-3.5.2-.9 1-1.5 1.9-1.5.7 0 1.3.3 1.9.6.3-.7.9-1.1 1.7-1.1.7 0 1.4.4 2.4.8.5.3 1.2.6 1.6.7 3.4.1 7.6 2.2 8.9 7.6.3.1.6.3.8.5.4.5.5 1.1.3 1.9-.2 1.2 0 2.4 0 2.4l.2.8-1.2 1.2c-.5 2.8-1.6 5.4-2.2 6.5-.1.1-.1.4-.1.8 1 .3 1.7.5 1.7.5l1 .4v.8c2.5.5 4.6 1.1 6.1 1.9 1.8.9 2.9 3.5 3.4 7.8l.1.6-.4.5c-4.6 5.9-11.5 9.4-19 9.4z'/%3E%3Cpath fill='%23fff' d='M45.4 36.8c-1.5-.8-3.9-1.5-7-2v-.9s-1-.4-2.6-.7c-.2-.8-.3-2 .2-2.8.5-.9 1.7-3.6 2.1-6.5l.9-.9s-.3-1.4 0-3c.2-.9-.4-.7-.9-.5-.9-7.1-6.3-7.7-7.8-7.7-1.4-.2-3.9-2.2-4.1-1.3-.1.9 1.2 1.8-.4 1.4-1.6-.4-3.1-1.8-3.3-.8-.2.7 1.2 2.3 2 3.1-1.2 1.3-2.1 3.2-2.4 6.1-.5-.3-1.4-.7-1.1.2.3 1.3 0 2.6 0 2.6l1.4 1.2c.5 2.7 1.5 5.1 2 6 .5.8.3 2.1.2 2.8-1.5.3-2.6.7-2.6.7v1.2c-2.5.5-4.4 1.1-5.8 1.7-2 1-2.6 5.7-2.7 7.9v.4c4.1 4.4 10 7.2 16.5 7.2 7.3 0 13.7-3.5 17.8-8.8-.1-2.3-.8-5.7-2.4-6.6z'/%3E%3C/g%3E%3C/svg%3E",setSourceCallback:()=>{},primarySource:"",initials:"",color:"#888888",background:"#f4f6f7",fontSize:0,fontWeight:100,fontFamily:"'Lato', 'Lato-Regular', 'Helvetica Neue'",offsetX:void 0,offsetY:void 0,width:void 0,height:void 0,useGravatar:!0,useGravatarFallback:!1,hash:"",email:"",fallback:"mm",rating:"x",forcedefault:!1,githubId:0,...e};let i=this.settings.fallbackImage;this.settings.primarySource?i=this.settings.primarySource:this.settings.useGravatar&&this.settings.useGravatarFallback?i=g.gravatarUrl(this.settings):this.settings.useGravatar?this.gravatarValid():this.settings.githubId?i=g.githubAvatar(this.settings):this.settings.initials.length>0&&(i=g.initialAvatar(this.settings)),this.setSource(i)}static from(t,e){return new g(t,e)}setSource(t){if(!this.element)throw new Error("No image element set.");t&&(this.element.src=t,this.settings.setSourceCallback(t))}gravatarValid(){if(!this.settings.email&&!this.settings.hash)return;const t=this.settings.email?h(this.settings.email):this.settings.hash,e=new window.Image;e.addEventListener("load",this.gravatarValidOnLoad.bind(this)),e.addEventListener("error",this.gravatarValidOnError.bind(this)),e.src=`https://secure.gravatar.com/avatar/${t}?d=404`}gravatarValidOnLoad(){this.setSource(g.gravatarUrl(this.settings))}gravatarValidOnError(){this.settings.initials.length>0?this.setSource(g.initialAvatar(this.settings)):this.setSource(this.settings.fallbackImage)}static initialAvatar(t){let e;try{e=document.createElement("canvas")}catch(t){return console.error("Canvas related error:",t),""}const i=t.width?t.width:t.size,a=t.height?t.height:t.size,r=Math.max(window.devicePixelRatio,1);e.width=i*r,e.height=a*r,e.style.width=`${i}px`,e.style.height=`${a}px`;const s=e.getContext("2d");if(!s)return console.error("Canvas context error."),"";const n=t.offsetX?t.offsetX:i/2,l=t.offsetY?t.offsetY:a/2;return s.scale(r,r),s.rect(0,0,e.width,e.height),s.fillStyle=t.background,s.fill(),s.font=`${t.fontWeight} ${t.fontSize||a/2}px ${t.fontFamily}`,s.textAlign="center",s.textBaseline="middle",s.fillStyle=t.color,s.fillText(t.initials,n,l),e.toDataURL("image/png")}static gravatarUrl(t){let{size:e=80,email:i="",hash:a="",fallback:r="mm",rating:s="x",forcedefault:n=!1}=t;e=e&&e>=1&&e<=2048?e:80;let l=a||i;l=l.toLowerCase().trim(),l&&"string"==typeof l||(l="00000000000000000000000000000000"),a=l.includes("@")?h(l):l;return`https://secure.gravatar.com/avatar/${a}?s=${e}&d=${r?encodeURIComponent(r):"mm"}&r=${s||"x"}${n?"&f=y":""}`}static githubAvatar(t){let{githubId:e=0,size:i=80}=t;return`https://avatars.githubusercontent.com/u/${e}?s=${i}&v=4`}}return g}();
