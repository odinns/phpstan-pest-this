# Releasing

## Release flow

1. Make sure the working tree contains only release changes.
2. Update `CHANGELOG.md` with the version, date, and notes.
3. Run the local quality gate:

   ```bash
   composer validate --strict
   composer check
   git diff --check
   ```

4. Commit the release prep:

   ```bash
   git add <intended files>
   git commit -m "chore: prepare 1.0.1 release"
   ```

5. Create an annotated tag:

   ```bash
   git tag -a v1.0.1 -m "v1.0.1"
   ```

6. Push main and the tag:

   ```bash
   git push origin main
   git push origin v1.0.1
   ```

7. Create a GitHub release from the tag and paste the matching changelog notes.
8. Confirm GitHub Actions passes.
9. Confirm Packagist indexes the new tag.

Packagist should update from the GitHub integration. If it does not, trigger an update from the Packagist package page.
