from pathlib import Path


REPLACEMENTS = {
    "ÃƒÂ¥": "å",
    "ÃƒÂ¤": "ä",
    "ÃƒÂ¶": "ö",
    "Ãƒâ€¦": "Å",
    "Ãƒâ€ž": "Ä",
    "Ãƒâ€“": "Ö",
    "ÃƒÂ©": "é",
    "ÃƒÂ¼": "ü",
    "ÃƒÂ±": "ñ",
    "Ã¢â‚¬Â¢": "•",
    "Ã¢â‚¬â€œ": "–",
    "Ã¢â‚¬â€": "—",
    "Ã¢â‚¬Å“": "“",
    "Ã¢â‚¬\u009d": "”",
    "Ã¢â‚¬â„¢": "’",
    "Ã¢â‚¬Â¦": "…",
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
}


def fix_text(text: str) -> str:
    fixed = text
    for _ in range(3):
        original = fixed
        for wrong, right in REPLACEMENTS.items():
            fixed = fixed.replace(wrong, right)
        if fixed == original:
            break
    return fixed


def main() -> None:
    path = Path("poc/jea-redesign/cache/videos-live.json")
    text = path.read_text(encoding="utf-8")
    fixed = fix_text(text)
    path.write_text(fixed, encoding="utf-8", newline="\n")
    print(f"Fixed {path}")


if __name__ == "__main__":
    main()
