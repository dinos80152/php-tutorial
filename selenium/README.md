# Selenium with PHPUnit Example

## User Story

作為一個未註冊使用者，我可以填寫姓與名，以註冊成為網站會員。

## Acceptance Test

* 成功註冊

```
Scenario: 註冊成功
    Given: first_name: Dino, last_name: Lai
    When: 按下送出
    Then: 跳轉頁面出現 Dino Lai
```

* 註冊失敗

```
Scenario: 重覆姓名
    Given: first_name: Scott, last_name: Kao
    When: 按下送出
    Then: 彈出警示視窗，文字為「此帳號已被註冊過。」
```

* 邊界測試

```
Scenario: 長度過長
    Given: first_name: ILoveSEMGOTeam, last_name: GarenaGagagagagagaga
    When: 輸入欄 UnFocus 時
    Then: 該欄位即會顯示為紅色
```

## Reference

* [[30天快速上手TDD][Day 21]ATDD - Acceptance Testing@In 91](https://dotblogs.com.tw/hatelove/2013/01/07/learning-tdd-in-30-days-day21-atdd-acceptance-testing)