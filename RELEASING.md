# Releasing

## v0.x release flow

1. Ensure main branch is green in CI.
2. Update `CHANGELOG.md` with the release date and notes.
3. Create and push an annotated tag:

   ```bash
   git tag -a v0.1.0 -m "v0.1.0"
   git push origin v0.1.0
   ```

4. Create a GitHub release from the tag and paste release notes.
5. Submit package on Packagist (first release only) and enable auto-updates from GitHub.

