# miguelmorera.com

## Commits

- Commits in this repo don't carry the `Co-Authored-By: Claude` trailer (as a rule).

## Branches

- `develop` holds the sources; `master` holds the compiled site and is what the server pulls.
  `dist/` is a git worktree of `master` (see `_docs/DEVELOPMENT.md`, "Releasing to master").
- `.htaccess` is copied to `dist/` by gulp (`copyHtaccess`), which drops the
  `# BEGIN local-only` ... `# END local-only` block: development-only rules go there.
