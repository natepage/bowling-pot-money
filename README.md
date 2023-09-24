# Bowling Coke Money

## Tech Foundation

- [ ] Integrate with bugsnag
- [X] Build FE with Symfony UX and Turbo
- [ ] Integrate against railway database (Remove db from AWS)
- [ ] Implement custom domain in AWS

## Security and Admin

- [X] Use Auth0 for authentication
- [X] Use EasyAdmin for admin interface
- [ ] Have different roles (Super Admin, Admin, User)
- [ ] Have separate logout for web and admin

## Teams

- [X] Manage teams from admin
- [X] Users can belong to many teams
- [X] Currency is set at team level
- [ ] Should be able to duplicate Achievements from another Team
- [ ] Have different team roles (who can withdraw money, etc)
- [X] Create invitation link for Team per email (once-off, expiry, support existing user)
- [ ] Automatic expiry for invitation links
- [ ] Send invite emails async
- [X] Restrict to max 10 members per team
- [ ] Allow team admin to cancel invite

## Achievements

- [X] Achievement belong to one Team
- [X] Achievement cost can be -/+
- [X] Achievement have a Currency, and it has to match their Team Currency

## Financials

- [ ] User/Team balance can go negative
- [ ] Achievements for a User/Team pair must be recorded as a ledger (last achievement contains balance)
- [ ] User/Team pair can pay in advance, so they are in credit
- [ ] Have history of payments for User/Team pair

## Sessions

- [ ] Session is a way to represent league nights, group User and Achievements occurrences
- [ ] Session also allow to capture bowling games, so we can build User/Team pair stats
- [X] Session can be opened/closed
- [ ] Session must be opened to add Achievement occurrence against User/Team pair

## Games

- [X] Game must belong to a SessionMember
- [X] SessionMember cannot have more than one opened game at a time
- [ ] Game must have a score before it can be closed
