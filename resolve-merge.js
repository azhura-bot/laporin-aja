const { execSync } = require('child_process');
const path = require('path');

const repoPath = 'c:\\Users\\Jaffray\\laporin-aja';
process.chdir(repoPath);

try {
  console.log('=== Git Status ===');
  console.log(execSync('git status').toString());
  
  console.log('\n=== Adding resolved files ===');
  execSync('git add resources/views/partials/auth-dropdown.blade.php');
  execSync('git add resources/views/partials/sidebar.blade.php');
  console.log('Files added successfully');
  
  console.log('\n=== Committing merge ===');
  console.log(execSync('git commit -m "Resolve merge conflicts in view templates"').toString());
  
  console.log('\n=== Final Status ===');
  console.log(execSync('git status').toString());
} catch (error) {
  console.error('Error:', error.message);
}
