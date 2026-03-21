import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toSlug(str: string): string {
    if (!str) return '';
    let slug = str.toLowerCase();
    // Normalize and remove accents
    slug = slug.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
    // Specific Vietnamese character handling
    slug = slug.replace(/[đĐ]/g, 'd');
    // Remove special characters, keep alphanumeric, space, and hyphen
    slug = slug.replace(/([^0-9a-z-\s])/g, '');
    // Replace multiple spaces/hyphens with a single hyphen
    slug = slug.replace(/[\s-]+/g, '-');
    // Remove leading and trailing hyphens
    slug = slug.replace(/^-+|-+$/g, '');
    return slug;
}
