param(
    [string]$PhpExe = "C:\Users\rietzr\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe",
    [string]$ServerHost = "127.0.0.1",
    [int]$Port = 8016
)

$ErrorActionPreference = "Stop"

$scriptRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$phpRoot = Split-Path -Parent $scriptRoot
$repoRoot = Split-Path -Parent (Split-Path -Parent $phpRoot)
$htmlRoot = Join-Path $repoRoot "poc\jea-redesign-html"

$pages = [ordered]@{
    "index" = "index.php"
    "aktuellt" = "aktuellt.php"
    "videos" = "videos.php"
    "ovningar" = "ovningar.php"
    "forts" = "forts.php"
    "teori" = "teori.php"
    "klasser" = "klasser.php"
    "betalningar" = "betalningar.php"
    "login" = "login.php"
}

$phpProcess = $null

try {
    $phpProcess = Start-Process -FilePath $PhpExe -ArgumentList "-S", "$ServerHost`:$Port", "-t", $phpRoot -PassThru -WindowStyle Hidden
    Start-Sleep -Seconds 2

    $utf8NoBom = New-Object System.Text.UTF8Encoding($false)

    foreach ($pageName in $pages.Keys) {
        $phpPage = $pages[$pageName]
        $uri = "http://$ServerHost`:$Port/$phpPage"
        $html = (Invoke-WebRequest -UseBasicParsing -Uri $uri).Content

        $html = $html -replace '(?<=["''(])\./([^"''()<>]+)\.php(?=["'' )])', './$1.html'
        $html = $html -replace 'data-page="([^"]+)\.php"', 'data-page="$1.html"'

        $outputPath = Join-Path $htmlRoot "$pageName.html"
        [System.IO.File]::WriteAllText($outputPath, $html, $utf8NoBom)
        Write-Host "Exported $pageName.html"
    }

    Copy-Item (Join-Path $phpRoot "app.js") (Join-Path $htmlRoot "app.js") -Force
    Copy-Item (Join-Path $phpRoot "styles.css") (Join-Path $htmlRoot "styles.css") -Force

    $fixScript = Join-Path $scriptRoot "fix-html-mojibake.py"
    python $fixScript

    Write-Host "Static HTML export complete."
}
finally {
    if ($null -ne $phpProcess -and -not $phpProcess.HasExited) {
        Stop-Process -Id $phpProcess.Id
    }
}
