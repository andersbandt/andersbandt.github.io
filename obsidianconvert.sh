#!/bin/bash

# Windows Python path (used as-is)
WIN_PYTHON="/cygdrive/c/Users/ander/AppData/Local/Programs/Python/Python312/python.exe"

# Use a Windows-style path (escaped correctly)
SCRIPT_PATH="C:\\Users\\ander\\OneDrive\\Code\\python\\text_processing\\md_to_html.py"

# Call it via Cygwin bash
"$WIN_PYTHON" "$SCRIPT_PATH"
