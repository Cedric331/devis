#!/usr/bin/env bash
set -euo pipefail

# Simulate CI workflow locally
act --dryrun -W .github/workflows/ci.yml
