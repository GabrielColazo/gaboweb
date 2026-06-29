<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Estilos (12 Variantes)</title>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f0f0f;
            color: #eee;
            margin: 0;
            padding: 40px 20px;
        }
        h1 { text-align: center; margin-bottom: 10px; color: #fff; letter-spacing: -1px; }
        p.intro { text-align: center; color: #888; margin-bottom: 50px; max-width: 600px; margin-left: auto; margin-right: auto; }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 40px;
            max-width: 1800px;
            margin: 0 auto;
        }

        .gallery-item {
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #333;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .gallery-item:hover { 
            border-color: #666; 
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .gallery-header {
            padding: 15px 20px;
            background: #000;
            border-bottom: 1px solid #222;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .gallery-title { font-weight: 600; font-size: 0.9rem; color: #fff; }
        .gallery-tag { 
            font-size: 0.7rem; 
            padding: 4px 8px; 
            border-radius: 6px; 
            background: #333; 
            color: #aaa; 
            font-family: 'Courier New', monospace;
            border: 1px solid #444;
        }

        .iframe-wrapper {
            position: relative;
            width: 100%;
            height: 550px;
            background: #fff;
            overflow: hidden;
        }
        iframe { width: 100%; height: 100%; border: none; }

        /* Etiquetas Visuales */
        .badge { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 8px; }
        .badge.ver { background: #f59e0b; } /* Naranja */
        .badge.hor { background: #10b981; } /* Verde */
        
        /* Ajustes visuales para la grilla */
        .mode-sidebar .iframe-wrapper { display: flex; justify-content: center; background: #eee; }
        .mode-sidebar iframe { width: 320px; border-left: 1px solid #ddd; border-right: 1px solid #ddd; }
        .mode-retro .iframe-wrapper { background: #000; }
        .mode-glass .iframe-wrapper { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    </style>
</head>
<body>

    <h1>Colección de Estilos v2.2</h1>
    <p class="intro">
        12 variaciones de configuración sobre el mismo núcleo PHP.<br>
        <span style="color:#10b981">●</span> Grid Horizontal &nbsp; <span style="color:#f59e0b">●</span> Stack Vertical
    </p>

    <div class="gallery-grid">

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Corporativo Clásico</span></div>
                <span class="gallery-tag">?variant=donweb</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=donweb"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge hor"></span><span class="gallery-title">Grid Ancho (2 Col)</span></div>
                <span class="gallery-tag">?variant=wide</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=wide"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Dark SaaS</span></div>
                <span class="gallery-tag">?variant=dark</span>
            </div>
            <div class="iframe-wrapper" style="background:#0f172a"><iframe src="demo_render.php?variant=dark"></iframe></div>
        </div>

        <div class="gallery-item mode-retro">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Retro Terminal (Hacker)</span></div>
                <span class="gallery-tag">?variant=retro</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=retro"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge hor"></span><span class="gallery-title">Sunny Playful (Pop)</span></div>
                <span class="gallery-tag">?variant=sunny</span>
            </div>
            <div class="iframe-wrapper" style="background:#fffbeb"><iframe src="demo_render.php?variant=sunny"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Elegant Serif</span></div>
                <span class="gallery-tag">?variant=elegant</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=elegant"></iframe></div>
        </div>

        <div class="gallery-item mode-glass">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Glassmorphism</span></div>
                <span class="gallery-tag">?variant=glass</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=glass"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge hor"></span><span class="gallery-title">Outline Pop</span></div>
                <span class="gallery-tag">?variant=outline</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=outline"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge hor"></span><span class="gallery-title">Big Typography</span></div>
                <span class="gallery-tag">?variant=big</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=big"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Minimalist B/W</span></div>
                <span class="gallery-tag">?variant=minimal</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=minimal"></iframe></div>
        </div>

        <div class="gallery-item">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Soft Neumorphism</span></div>
                <span class="gallery-tag">?variant=soft</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=soft"></iframe></div>
        </div>

        <div class="gallery-item mode-sidebar">
            <div class="gallery-header">
                <div><span class="badge ver"></span><span class="gallery-title">Widget Lateral</span></div>
                <span class="gallery-tag">?variant=compact</span>
            </div>
            <div class="iframe-wrapper"><iframe src="demo_render.php?variant=compact"></iframe></div>
        </div>

    </div>
</body>
</html>