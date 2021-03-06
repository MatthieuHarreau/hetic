var canvas     = null,
    context    = null,
    coords     = null,
    particules = null,
    count      = 5,
    gravity    = 0.05,
    stats      = null;

window.onload = function()
{
    canvas  = document.getElementById('canvas');
    context = canvas.getContext('2d');
    coords = {
        x : 0,
        y : 0
    };
    particules = Array();

    window.onmousemove = function(e)
    {
        coords.x = e.clientX;
        coords.y = e.clientY;
    };

    stats = new Stats();
    stats.setMode(1); // 0: fps, 1: ms

    // Align top-left
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.left = '0px';
    stats.domElement.style.top = '0px';

    document.body.appendChild( stats.domElement );

    requestAnimFrame(loop);


    var gui = new dat.GUI();
    gui.add(window,'count',0,10);
    gui.add(window,'gravity',-0.5,0.5);
};

function loop()
{
    stats.end();
    stats.begin();

    requestAnimFrame(loop);
    update();
    create();
    draw();
}

function draw()
{
    var particule = null;
    context.clearRect(0,0,canvas.width,canvas.height);
    for(var i = 0; i < particules.length; i++)
    {
        particule = particules[i];
        context.beginPath();
        context.fillStyle = particule.c;
        if(particule.life < 100)
            context.globalAlpha = particule.life / 100;
        context.arc(particule.x,particule.y,particule.r,0,Math.PI*2);
        context.fill();
    }
}

function update()
{
    var particule = null;
    for(var i = 0; i < particules.length; i++)
    {
        particule = particules[i];
        particule.speed_y += gravity;
        particule.x += particule.speed_x;
        particule.y += particule.speed_y;
        particule.life--;

        if(particule.x < 0 || particule.y < 0 || particule.x > canvas.width || particule.y > canvas.height || particule.life < 0)
        {
            particules.splice(i,1);
            i--;
        }
    }
}

function create()
{
    if(particules.length < 10000)
    {
        for(var i = 0; i < count; i++)
        {
            var particule = {
                x       : coords.x,
                y       : coords.y,
                r       : Math.random() * 10,
                c       : 'hsl(' + Math.random() * 360 + ',100%,50%)',
                life    : 120,
                speed_x : Math.random() * 2 - 1,
                speed_y : - Math.random() * 6
            };
            particules.push(particule);
        }
    }
}





/* Compatible avec tous les navigateurs */
window.requestAnimFrame = (function()
{
    return  window.requestAnimationFrame       ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame    ||
            function(callback)
            {
                window.setTimeout(callback, 1000 / 60);
            };
})();