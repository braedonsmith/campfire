import { User } from '@/types';
import { getLocalTimeZone, now, parseAbsolute } from '@internationalized/date';

export function formatName(member?: User) {
    if (!member) {
        return "Unassigned";
    }

    return `${member.rank} ${member.first_name} ${member.last_name}`;
}

export function formatTimestamp(iso: string) {
    const date = parseAbsolute(iso, getLocalTimeZone()).toDate();

    const parts = new Intl.DateTimeFormat('en-US', {
        timeZone: getLocalTimeZone(),
        year: 'numeric',
        month: 'short',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hourCycle: 'h23'
    }).formatToParts(date);

    const { day, month, year, hour, minute } = Object.fromEntries(
        parts
            .filter((part) => part.type !== 'literal')
            .map((part) => [part.type, part.value])
    );

    return `${day} ${month} ${year} ${hour}:${minute}`;
}

const MS_PER_MINUTE = 60 * 1000;
const MS_PER_HOUR = MS_PER_MINUTE * 60;
const MS_PER_DAY = MS_PER_HOUR * 24;
const MS_PER_MONTH = MS_PER_DAY * 30;
const MS_PER_YEAR = MS_PER_DAY * 365;

export function formatRelativeTime(iso: string) {
    const date = parseAbsolute(iso, getLocalTimeZone()).toDate().getTime();
    const current = Date.now();

    const elapsed = date - current;

    const rtf = new Intl.RelativeTimeFormat('en-US', { style: 'long' });

    if (MS_PER_MINUTE <= elapsed && elapsed < 0) {
        return 'in less than a minute';
    }

    if (0 <= elapsed && elapsed < MS_PER_MINUTE) {
        return 'now';
    }

    if (Math.abs(elapsed) > MS_PER_YEAR) {
        return rtf.format(Math.floor(elapsed / MS_PER_YEAR), 'year');
    }

    if (Math.abs(elapsed) > MS_PER_MONTH) {
        return rtf.format(Math.floor(elapsed / MS_PER_MONTH), 'month');
    }

    if (Math.abs(elapsed) > MS_PER_DAY) {
        return rtf.format(Math.floor(elapsed / MS_PER_DAY), 'day');
    }

    if (Math.abs(elapsed) > MS_PER_HOUR) {
        return rtf.format(Math.floor(elapsed / MS_PER_HOUR), 'hour');
    }

    return rtf.format(Math.floor(elapsed / MS_PER_MINUTE), 'minute');
}
