<html> 
<head> 
    <style> 
        body { font-family: DejaVu Sans, sans-serif; } 
        .card { border: 1px solid #000; padding: 10px; margin: 10px; width: 200px; height: 300px; display: inline-block; vertical-align: top; } 
        .word { font-size: 24px; font-weight: bold; text-align: center; margin-top: 50px; } 
        .definition { font-size: 16px; text-align: center; margin-top: 20px; } 
    </style>
</head>
<body> 
   

    @foreach($words as $key => $word) 
        <div class="card"> 
            <div class="word">{{ $word->category }}</div> 
            <div class="definition">{{ $word->english }}</div> 
        </div> 
    @endforeach 
</body>
</html>