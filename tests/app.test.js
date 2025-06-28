const { test, expect } = require('@playwright/test');

test('App loads and shows DB data', async ({ page }) => {
  const APP_URL = process.env.APP_URL;
  await page.goto(APP_URL, { waitUntil: 'domcontentloaded' });

  // Check content from the 'test' table
  await expect(page.locator('body')).toContainText('optimy');
  await expect(page.locator('body')).toContainText('Social impact');
  await expect(page.locator('body')).toContainText('Sustainability');
  await expect(page.locator('body')).toContainText('Philanthropy');
});
