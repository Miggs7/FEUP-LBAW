-- TRIGGER 1 Edit review comment by owner
DROP FUNCTION IF EXISTS edit_review_comment CASCADE;
CREATE FUNCTION edit_review_comment() RETURNS trigger AS
$BODY$
BEGIN
    UPDATE review SET comment = NEW.comment WHERE id = OLD.id;
    RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS edit_review_comment on review CASCADE;
CREATE TRIGGER edit_review_comment
AFTER UPDATE ON review
FOR EACH ROW
EXECUTE PROCEDURE edit_review_comment();

-- TRIGGER 2 stop auction from being ongoing (BR04)
DROP FUNCTION IF EXISTS auction_time_expired CASCADE;
CREATE FUNCTION auction_time_expired () RETURNS trigger AS
$BODY$
BEGIN
    IF(auction.ending_date == now()) THEN
        UPDATE auction SET ongoing = 0 WHERE id = OLD.id;
        RETURN NEW;
    END IF;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS auction_time_expired on auction CASCADE;
CREATE TRIGGER auction_time_expired
BEFORE UPDATE ON auction
FOR EACH ROW
EXECUTE PROCEDURE auction_time_expired();


-- TRIGGER 3 Only let being bid values bigger than the current(BR06)

DROP FUNCTION IF EXISTS check_bid CASCADE;
CREATE FUNCTION check_bid () RETURNS trigger AS
$BODY$
BEGIN
    IF(bid.bid_value > auction.current_value && auction.ongoing == 1) THEN
        UPDATE auction SET current_value = bid.bid_value WHERE id = OLD.id;
        RETURN NEW;
    END IF;
END;
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS auction_time_expired on auction CASCADE;
CREATE TRIGGER check_bid
BEFORE UPDATE ON auction
FOR EACH ROW
EXECUTE PROCEDURE check_bid();

