#!/bin/sh

# All commands below must not fail
set -eu

# Go to root dir
cd "$(dirname $0)/../"

echo "Running in: $PWD"

find tests/Cases -type f -print0 | xargs -0 sed -i 's/function setUpBeforeClass()/function setUpBeforeClass(): void/g';
find tests/Cases -type f -print0 | xargs -0 sed -i 's/function setUp()/function setUp(): void/g';
find tests/Cases -type f -print0 | xargs -0 sed -i 's/function tearDown()/function tearDown(): void/g';

echo "Done"

# Return back to original dir
cd - > /dev/null
