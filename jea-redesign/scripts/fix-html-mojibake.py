from pathlib import Path


REPLACEMENTS = {
    "Ã¥": "å",
    "Ã¤": "ä",
    "Ã¶": "ö",
    "Ã…": "Å",
    "Ã„": "Ä",
    "Ã–": "Ö",
    "Ã©": "é",
    "Ã¼": "ü",
    "Ã±": "ñ",
    "â€¢": "•",
    "â€“": "–",
    "â€”": "—",
    "â€œ": "“",
    "â€\u009d": "”",
    "â€™": "’",
    "â€¦": "…",
    "Â ": " ",
    "Â": "",
    "\x00": " ",
}


def fix_text(text: str) -> str:
    for wrong, right in REPLACEMENTS.items():
        text = text.replace(wrong, right)
    return text


def main() -> None:
    root = Path("poc/jea-redesign-html")
    targets = list(root.glob("*.html")) + [root / "app.js"]

    for path in targets:
        text = path.read_text(encoding="utf-8")
        fixed = fix_text(text)
        path.write_text(fixed, encoding="utf-8", newline="\n")
        print(f"Fixed {path}")


if __name__ == "__main__":
    main()
