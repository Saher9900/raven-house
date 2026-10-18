import puppeteer from "puppeteer-core";

const browser = await puppeteer.launch({
    executablePath: "C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe",
    headless: true,
    args: ["--window-size=390,844", "--hide-scrollbars"],
    defaultViewport: { width: 390, height: 844, deviceScaleFactor: 2, isMobile: true, hasTouch: true },
});

const page = await browser.newPage();
await page.goto("http://ravon-house.test/", { waitUntil: "networkidle0", timeout: 30000 });

const openAndMeasure = async (label) => {
    await page.click(".navbar-toggler-raven");
    await page.waitForSelector("#mobileMenu.show", { timeout: 5000 });
    await new Promise((resolve) => setTimeout(resolve, 400));
    const metrics = await page.evaluate(() => ({
        innerWidth: window.innerWidth,
        scrollWidth: document.documentElement.scrollWidth,
        bodyScrollWidth: document.body.scrollWidth,
        langButtonLeft: document.querySelector(".language-switch__button--mobile")?.getBoundingClientRect().left,
        langButtonRight: document.querySelector(".language-switch__button--mobile")?.getBoundingClientRect().right,
        menuRight: document.querySelector("#mobileMenu")?.getBoundingClientRect().right,
        menuLeft: document.querySelector("#mobileMenu")?.getBoundingClientRect().left,
        menuWidth: document.querySelector("#mobileMenu")?.getBoundingClientRect().width,
    }));
    console.log(label, metrics);
    await page.screenshot({ path: `${process.env.TEMP}\\raven-${label}.png` });
    return metrics;
};

await openAndMeasure("en-open");
await page.click(".mobile-perfume-nav__toggle");
await new Promise((resolve) => setTimeout(resolve, 400));
await openAndMeasure("en-perfume");

await browser.close();
